<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
	public function index(Request $req){
		
		$result = DB::table('slider')->orderBy('id', 'DESC')->take(3)->get();;
		//echo $result;
		//print_r($result);
		return view('index', ['user'=>$result]);
	}
	
	public function admin(Request $req){
		return view('home.admin');
	}
	
   	public function representative(Request $req){
		return view('home.representative');
	}
	
	public function manager(Request $req){
		return view('home.manager');
	}
	
	
	public function show_contact(Request $req){
		return view('contact');
	}
	
	public function about(Request $req){
		return view('about');
	}
	
	public function add_contact(Request $req){
		
		$req->validate([

            "name"     => "required",
            "email"  => "required",
            "subject"  => "required",
            "message"  => "required",

        ]);
		
		DB::table('inbox')->insert(
    ['userName' => $req->name,'subject' => $req->subject,'email_from' => $req->email, 'email_to' => 'rana@gmail.com','message' => $req->message]
    );
        echo "successfull";
	}
}
