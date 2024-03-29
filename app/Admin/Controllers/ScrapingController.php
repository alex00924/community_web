<?php
#app/Http/Admin/Controllers/ShopNewsController.php
namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\ShopBrand;
// use Validator;
//use App\Admin\XMLWriter2;

class ScrapingController extends Controller
{
    public $languages;

    public function __construct()
    {

    }

    public function index()
    {
        return view('admin.screen.scraping_bd');
    }

    public function mr_admin()
    {
        return view('admin.screen.scraping_mr');
    }
    /**
     * email extractor
     * @param Request $request  
     */
    public function email_extractor(Request $request)
    {
        $path = $request['scrape'];
        $fileName = str_replace('.csv', ' scraped.csv', $_FILES['scrape']['name']);

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

            //get email in text
            //$pattern = '/[a-zA-Z0-9_\-\+\.]+@[a-zA-Z0-9\-]+\.([a-z0-9_\-\+\.]{2,20})(?:\.[a-z0-9_\-\+\.]{2})?/i';
            $pattern = '/[a-zA-Z0-9_\-\+\.]+@[a-zA-Z0-9\-]+\.([a-z0-9_\-\+\.]{2,25})?/i';
            preg_match_all($pattern, $html, $matches);
            $result = $matches[0];
            
            //valite email
            $key = array_search('email@example.com', $result);
            unset($result[$key]);
            $emails = array_unique($result);
            //dd($emails);
            
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
            //dd($author_list);

            //Journal
            $pos1 = strpos($html, '<span class="citation-journal">');
            if ($pos1 !== false) {
                $sub_str = substr($html, $pos1 + 31);
                $pos2 = strpos($sub_str, '<span class="citation-separator">');
                $journal = trim(substr($sub_str, 0, $pos2));
            } else {
                $journal = '';
            }

            //Publication name
            $pos1 = strpos($html, '<title>');
            $sub_str = substr($html, $pos1 + 7);
            $pos2 = strpos($sub_str, '</title>');
            $title = substr($sub_str, 0, $pos2 - 9);

            //Year
            $pos1 = strpos($html, '<time class="citation-year">');
            if ($pos1 !== false) {
                $sub_str = substr($html, $pos1 + 28);
                //$pos2 = strpos($sub_str, '</time>');
                $year = substr($sub_str, 0, 4);
            } else {
                $year = '';
            }

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

                    if (substr($email, -1) == '.') {
                        $scape['email']   = substr($email,0,strlen($email) - 1);
                    } else {
                        $scape['email']   = $email;
                    }
                    $scape['title']   = $title;
                    $scape['journal'] = $journal;
                    $scape['year']    = $year;
                    array_push($scapingData, $scape);
                }
            }
        }
        fclose($file);
        //dd($scapingData);

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=" . $fileName,
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

    /**
     * website scraping
     * @param Request $request  
     */
    public function web_scraping(Request $request)
    { 
        $file = $request->web_scrape;
        $destinationPath = 'uploads';
        $file->move($destinationPath, 'input.csv');
        $output = shell_exec('/home/fluidsforlife/.local/bin/scrapy crawl emailspider');
        echo json_encode(array('res'=> $output));
        exit;
    }

    public function getName($email)
    {
        global $author_list;
        $author_name = [];
        $sel_author = '';
        $str = explode("@",$email);
        $email = $str[0];

        if (count($author_list) > 0) {
            foreach ($author_list as $author) {
                $list = explode(" ", $author);
                $name1 = $list[0];
                $name2 = $list[count($list) - 1];

                $pos1 = strpos(strtolower($email), strtolower(str_replace('-','',$name1)));
                $pos2 = strpos(strtolower($email), strtolower(str_replace('-','',$name2)));

                if ($pos1 > 1) {//  if first name exist
                    $author_name[0] = $name2;
                    $author_name[1] = $name1;
                } else if ( $pos2 > 1 ) { // if last name exist
                    $author_name[0] = $name1;
                    $author_name[1] = $name2;
                }

                if ($pos1 !== false && $pos2 !== false) {// if both exist
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
                } else if ($pos1 !== false) { // if forst name exist only
                    if ($pos1 == 0) {
                        $author_name[0] = $name1;
                        $author_name[1] = $name2;
                    } else {
                        $author_name[0] = $name2;
                        $author_name[1] = $name1;
                    }
                    $sel_author = $author;
                } else if ($pos2 !== false) { // last name exist only
                    if ($pos2 == 0) {
                        if (strtolower($name2) == strtolower($email)) {
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

                if (empty($author_name)) { // if first character of first name and last name exist
                    $search1 = '';
                    $search2 = '';
                    $search3 = '';
                    $search_pos1 = false;
                    $search_pos2 = false;
                    $search_pos3 = false;

                    foreach ($list as $str) {
                        $search1 .= substr($str,0,1);
                        if (strlen($str) > 1) {
                            $search2 .= substr($str,0,2);
                        }
                        if (strlen($str) > 2) {
                            $search3 .= substr($str,0,3);
                        }
                    }

                    if ($search1) $search_pos1 = strpos(strtolower($email), strtolower($search1));
                    if ($search2) $search_pos2 = strpos(strtolower($email), strtolower($search2));
                    if ($search3) $search_pos3 = strpos(strtolower($email), strtolower($search3));

                    if ($search_pos1 !== false || $search_pos2 !== false || $search_pos3 !== false ) {
                        $author_name[0] = $name1;
                        $author_name[1] = $name2;
                        $sel_author = $author;
                    }
                }
            }

            if (empty($author_name)) { // if first character of first name or last name exist one time
                $cnt1 = 0;
                $cnt2 = 0;
                foreach ($author_list as $author) {
                    $list = explode(" ", $author);
                    $name1 = $list[0];
                    $name2 = $list[count($list) - 1];

                    if (strtolower(substr($name1,0,1)) === strtolower(substr($email,0,1))) {
                        $author_name[0] = $name1;
                        $author_name[1] = $name2;
                        $sel_author = $author;
                        $cnt1 ++;
                    } else if (strtolower(substr($name2,0,1)) === strtolower(substr($email,0,1))) {
                        $author_name[0] = $name2;
                        $author_name[1] = $name1;
                        $sel_author = $author;
                        $cnt2 ++;
                    }
                }

                if ($cnt1 != 1 && $cnt2 != 1) {
                    $sel_author = '';
                    $author_name = [];
                }
            }

            if (empty($author_name)) { // similar percent 70% over
                foreach ($author_list as $author) {
                    $list = explode(" ", $author);
                    $name1 = $list[0];
                    $name2 = $list[count($list) - 1];
                    $sim1 = similar_text(strtolower($name1), strtolower($email), $perc1);
                    $sim2 = similar_text(strtolower($name2), strtolower($email), $perc2);

                    if ($perc1 > 70 || $perc2 > 70) {
                        $author_name[0] = $name1;
                        $author_name[1] = $name2;
                        $sel_author = $author;
                    }
                }
            }
        }

        if ($sel_author) { // remove existing author name in author array
            $key = array_search($sel_author, $author_list);
            unset($author_list[$key]);
        }

        return $author_name;
    }

    public function getUrlContent($url){
        $curl_handle=curl_init();
        curl_setopt($curl_handle, CURLOPT_URL,$url);
        curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl_handle, CURLOPT_USERAGENT, 'Mozilla/5.0');
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, false);
        $query = curl_exec($curl_handle);
        curl_close($curl_handle);
        $query =  htmlentities($query);

        return $query;
    }

    public function getEmail($html)
    {
        //get email in text
        $pattern = '/[a-zA-Z0-9_\-\+\.]+@[a-zA-Z0-9\-]+\.([a-z0-9_\-\+\.]{2,25})?/i';
        preg_match_all($pattern, $html, $matches);
        $result = $matches[0];
        
        //valite email
        $key = array_search('email@example.com', $result);
        if ($key) {
            unset($result[$key]);
        }
        $emails = array_unique($result);

        return $emails;
    }

    public function crunchbase_scraping()
    {
        
    }

    public function linkedin_scraping(Request $request)
    {  
        $searchkey =  $request->field;
        $output = shell_exec("/home/fluidsforlife/.local/bin/python3 linkedinjob.py $searchkey");
        echo json_encode(array('res'=> $output));
        exit;
    }

    public function email_generator(Request $request)
    {
        $path = $request->email_scrape;
        $inputfile = fopen($path,"r");
        $output = []; 
        fgetcsv($inputfile, 1000, ",");
        while (($data = fgetcsv($inputfile, 1000, ",")) !== FALSE) {
            $output[] = $data;
        }
        $outputfile = fopen("./uploads/email_generator.csv","w");
        $columns = array('Company', 'Email Pattern', 'First Name', 'Last Name', 'Email');
        fputcsv($outputfile, $columns);
        foreach ($output as $line) {
            $email="";
            if ($line[1] === "[FN].[LN]") {
                $email = $line[2] . '.' . $line[3] . '@' . strtolower(str_replace(' ', '', $line[0])) . '.com';
            } else if ($line[1] === "[Fi][LN]") {
                $email = substr($line[2],0,1) . '' . $line[3] . '@' . strtolower(str_replace(' ', '', $line[0])) . '.com';
            } else if ($line[1] === "[FN]") {
                $email = $line[2] . '@' . strtolower(str_replace(' ', '', $line[0])) . '.com';
            } else if ($line[1] === "[LN][Fi]") {
                $email = $line[3] . '' . substr($line[2],0,1) . '@' . strtolower(str_replace(' ', '', $line[0])) . '.com';
            } else {
                $email = $line[2] . '.' . $line[3] . '@' . strtolower(str_replace(' ', '', $line[0])) . '.com';
            }
            array_push($line, $email);
            fputcsv($outputfile, $line);
        }
        fclose($inputfile);
        echo json_encode(array('res' => 1));
    }
    
    public function email_validate(Request $request)
    {   
        $file = $request->email_checker;    
        $inputfile = fopen($file,"r");
        $output = []; 
        while (($data = fgetcsv($inputfile, 1000, ",")) !== FALSE) {
            array_push($output, $data);
        }
        $outputfile = fopen("./uploads/validate_email.csv","w");
        $columns = array('Lead', 'Full Name', 'First Name', 'Last Name', 'Position', 'Company', 'Email', 'Alt.Email', 'Alt.Email2', 'Interest', 'Role', 'Organization Type', 'Relationship', 'Notes', 'LinkedIn', 'Phone', 'Degrees', 'Location', 'Industry', 'Max connection', 'Publication name', 'Journal', 'Year', 'PMID', 'Search');
        fputcsv($outputfile, $columns);
        foreach ($output as $line) {
            $api_key = 'f888149889e6457ba071e58145f3d748';
            if ($line[6] !== "(blank)" && $line[6] !== "") {
                $ch = curl_init('https://emailvalidation.abstractapi.com/v1/?api_key='.$api_key.'&email='.$line[6]);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                $data = curl_exec($ch);
                curl_close($ch);
                $convertdata = json_decode($data);
                
                if ($convertdata->is_smtp_valid->value == 1) {
                    fputcsv($outputfile, $line);
                }
            }
        }
        fclose($inputfile);
        echo json_encode(array('res' => 1));
    }

    public function createImage()
    {
        $data = [
            'title' => trans('scraping.admin.add_new_title'),
            'sub_title' => '',
            'title_description' => trans('scraping.admin.add_new_des'),
            'icon' => 'fa fa-plus',
            'imagedb' => [],
            'url_action' => route('admin_scraping.add_image'),
        ];
        return view('admin.screen.image_database')
            ->with($data);
    }

    public function postcreateImage()
    {
        $data = request()->all();

        $validator = Validator::make($data, [
            'name' => 'required|string|max:100',
            'taglist' => 'required',
            'image' => 'required',
        ],[
            'name.required' => trans('validation.required', ['attribute' => trans('scraping.name')]),
            'taglist.required' => trans('validation.required', ['attribute' => trans('scraping.taglist')]),
            'image.required' => trans('validation.required', ['attribute' => trans('scraping.image')]),
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($data);
        }
        $dataInsert = [
            'image' => $data['image'],
            'name' => $data['name'],
            'taglist' => $data['taglist'],
        ];
        ShopBrand::create($dataInsert);

        return redirect()->route('admin_brand.index')->with('success', trans('brand.admin.create_success'));
    }

    public function search_image()
    {
        # code...
    }
}