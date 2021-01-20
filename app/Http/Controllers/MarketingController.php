<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MarketingQuestionaireEmail;
use App\Models\MarketQuestionaireUrl;
use App\Mail\LinkMail;

class MarketingController extends GeneralController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
      return view($this->templatePath . '.marketing');
    }

    /**
     * website scraping
     * @param Request $request  
     */
    public function sendEmail(Request $request)
    {
        $email = $request->email;
        $dataInsert = [
          "email" => $email,
          "shared" => false
        ];
        MarketingQuestionaireEmail::create($dataInsert);
        echo json_encode(array('res'=> "success"));    
    }

    public function sendLink(Request $request)
    {

      // Mail::to($traveler_email)->send(new PayAgain($id));
    }

    public function research()
    {
      return view($this->templatePath . '.marketing_research');
    }
   
}

?>