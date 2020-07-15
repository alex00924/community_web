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

        while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
            $scape = [];
            //get text in scientic publish
            $html = file_get_contents('https://pubmed.ncbi.nlm.nih.gov/' . $data[0]);
            //get email in text
            $pattern = '/[a-z0-9_\-\+\.]+@[a-z0-9\-]+\.([a-z]{2,4})(?:\.[a-z]{2})?/i';
            preg_match_all($pattern, $html, $matches);
            $result = $matches[0];
            //valite email
            $key = array_search('email@example.com', $result);
            unset($result[$key]);
            $emails = array_unique($result);
            //get csv's data
            if (empty($emails)) {
                $scape['pmid'] = $data[0];
                $scape['email'] = '';
                array_push($scapingData, $scape);
            } else {
                foreach ($emails as $email) {
                    $scape['pmid'] = $data[0];
                    $scape['email'] = $email;
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

        //$columns = array('PMID', 'Email');

        $callback = function() use ($scapingData)
        {
            $file = fopen('php://output', 'w');
            //fputcsv($file, $columns);

            foreach($scapingData as $line) {
                fputcsv($file, $line);
            }
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);

    }
}
