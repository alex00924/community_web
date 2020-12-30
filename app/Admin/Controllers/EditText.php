<?php
namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class EditTextController extends Controller
{
    public $languages;

    public function __construct()
    {

    }

    public function index()
    {
        return view('admin.screen.scraping_bd');
    }  
   
}