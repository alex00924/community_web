<?php
#app/Http/Admin/Controllers/ShopNewsController.php
namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class ScrapingController extends Controller
{
    public $languages;

    public function __construct()
    {

    }

    public function index()
    {
        return view('admin.screen.scraping');
    }

    /**
     * email extractor
     * @param Request $request  
     */
    public function email_extractor(Request $request)
    {
        $path = $request['scrape'];

        if (empty($path)) {
            return redirect()->back();
        }

        $file = fopen($path,"r");
        $scapingData = [];
        global $author_list;

        while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
            $scape = [];
            //get text in scientic publish
            $html = file_get_contents('https://pubmed.ncbi.nlm.nih.gov/' . $data[0]);
            //$html = mb_convert_encoding($html, 'HTML-ENTITIES', "UTF-8");
            //$html = mb_convert_encoding($html, 'UTF-8', mb_detect_encoding($html, 'UTF-8, ISO-8859-1', true));
            /*$html = mb_convert_encoding(
                mb_convert_encoding($html, 'UTF-8', mb_detect_encoding($html, 'UTF-8, ISO-8859-1', true)),
                'HTML-ENTITIES',
                'UTF-8'
            );*/

            //get email in text
            $pattern = '/[a-z0-9_\-\+\.]+@[a-z0-9\-]+\.([a-z]{2,4})(?:\.[a-z]{2})?/i';
            preg_match_all($pattern, $html, $matches);
            $result = $matches[0];
            
            //valite email
            $key = array_search('email@example.com', $result);
            unset($result[$key]);
            $emails = array_unique($result);
            
            //full name
            $sub = $html;
            $author_list = [];
            $pos = strpos($sub, 'data-ga-action="author_link"');
            while ($pos > 0) {
                $sub = trim(substr($sub, $pos + 28));
                $pos1 = strpos($sub, '">');
                $full_name = substr($sub, 15, $pos1 - 15);
                array_push($author_list,$full_name);
                $pos = strpos($sub, 'data-ga-action="author_link"');
            }
            $author_list = array_unique($author_list);
            //dd($html);
            /*$pos1 = strpos($html, '<span class="full-name">');
            $sub_str = substr($html, $pos1 + 24);
            $pos2 = strpos($sub_str, '</span>');
            $full_name = substr($sub_str, 0, $pos2);
            //$full_name = $author_list[count($author_list) - 1];
            $pos3 = strpos($full_name, ' ');
            $first_name = substr($full_name, 0, $pos3);
            $last_name = substr($full_name, $pos3 + 1);*/

            //Journal
            $pos1 = strpos($html, '<span class="citation-journal">');
            $sub_str = substr($html, $pos1 + 31);
            $pos2 = strpos($sub_str, '<span class="citation-separator">');
            $journal = trim(substr($sub_str, 0, $pos2));

            //Publication name
            $pos1 = strpos($html, '<title>');
            $sub_str = substr($html, $pos1 + 7);
            $pos2 = strpos($sub_str, '</title>');
            $title = substr($sub_str, 0, $pos2 - 9);

            //Year
            $pos1 = strpos($html, '<time class="citation-year">');
            $sub_str = substr($html, $pos1 + 28);
            //$pos2 = strpos($sub_str, '</time>');
            $year = substr($sub_str, 0, 4);

            //get csv's data
            if (empty($emails)) {
                $scape['pmid']       = $data[0];
                $scape['first_name'] = '';
                $scape['last_name']  = '';
                $scape['email']      = '';
                $scape['title']      = $title;
                $scape['journal']    = $journal;
                $scape['year']       = $year;
                array_push($scapingData, $scape);
            } else {
                foreach ($emails as $email) {
                    $scape = [];
                    $scape['pmid'] = $data[0];
                    $author_name   = $this->getName($email);
                    
                    if (count($author_name) > 0) {
                        $scape['first_name'] = $author_name[0];
                        $scape['last_name']  = $author_name[1];
                    } else {
                        $scape['first_name'] = '';
                        $scape['last_name']  = '';
                    }
                    $scape['email']   = $email;
                    $scape['title']   = $title;
                    $scape['journal'] = $journal;
                    $scape['year']    = $year;
                    array_push($scapingData, $scape);
                }
            }
        }
        fclose($file);

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=scraping.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );


        $callback = function() use ($scapingData)
        {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            $columns = array('PMID', 'First Name', 'Last Name', 'Email', 'Publication name', 'Journal', 'Year');
            fputcsv($file, $columns);

            foreach($scapingData as $line) {
                fputcsv($file, $line);
            }
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);

    }

    public function getName($email)
    {
        global $author_list;
        $author_name = [];
        $sel_author = '';
        if (count($author_list) > 0) {
            foreach ($author_list as $author) {
                $list = explode(" ", $author);
                $name1 = $list[0];
                $name2 = $list[count($list) - 1];

                $pos1 = strpos(strtolower($email), strtolower($name1));
                $pos2 = strpos(strtolower($email), strtolower($name2));

                if ($pos1 > 1) {
                    $author_name[0] = $name2;
                    $author_name[1] = $name1;
                } else if ( $pos2 > 1 ) {
                    $author_name[0] = $name1;
                    $author_name[1] = $name2;
                }

                if ($pos1 !== false && $pos2 !== false) {
                    if ($pos1 == 0) {
                        $author_name[0] = $name1;
                        $author_name[1] = $name2;
                    } else if ( $pos2 == 0 ) {
                        $author_name[0] = $name2;
                        $author_name[1] = $name1;
                    }
                    $key = array_search($author, $author_list);
                    unset($author_list[$key]);
                    break;
                } else if ($pos1 !== false) {
                    if ($pos1 == 0) {
                        $author_name[0] = $name1;
                        $author_name[1] = $name2;
                    } else {
                        $author_name[0] = $name2;
                        $author_name[1] = $name1;
                    }
                    $sel_author = $author;
                } else if ($pos2 !== false) {
                    if ($pos2 == 0) {
                        $str = explode("@",$email);
                        if (strtolower($name2) == strtolower($str[0])) {
                            $author_name[0] = $name1;
                            $author_name[1] = $name2;
                        } else {
                            $author_name[0] = $name2;
                            $author_name[1] = $name1;
                        }
                    } else {
                        $author_name[0] = $name1;
                        $author_name[1] = $name2;
                    }
                    $sel_author = $author;
                }
            }
        }

        /*if (empty($author_name)) {
            $full_name = $author_list[count($author_list) - 1];
            $list = explode(" ", $full_name);
            $author_name[0] = $list[0];
            $author_name[1] = $list[count($list) - 1];
            $sel_author = $full_name;
        }*/

        if ($sel_author) {
            $key = array_search($sel_author, $author_list);
            unset($author_list[$key]);
        }

        return $author_name;
    }
}
