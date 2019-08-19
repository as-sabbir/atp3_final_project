<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
	
    public function show_users(){
		$data = DB::table('users')->get();
		//echo $data;
		return view('home.admin.show_users', ['user'=>$data]);
	}
	
 

    public function search(Request $req){
		if($req->search){
		$data = DB::table('users')
		//IF ANY OF THE COLOUMN MATCH FIND BELOW FOREACH LOOP.........
		->where('id','like','%'.$req->search . '%')
		->orwhere('firstName','like','%'.$req->search . '%')
		->orwhere('lastName','like','%'.$req->search . '%')
		->orwhere('phone','like','%'.$req->search . '%')
		->orwhere('email','like','%'.$req->search . '%')
		->orwhere('userName','like','%'.$req->search . '%')
		->orwhere('gender','like','%'.$req->search . '%')
		->orwhere('dateOfBirth','like','%'.$req->search . '%')
		->orwhere('user_role','like','%'.$req->search . '%')
		->get();
		//echo $data;
		
		if($data){
			foreach($data as $value => $search){
				echo '<tr> <td>' . $search->id . '</td>
				           <td>' . $search->firstName . '</td>
				           <td>' . $search->lastName . '</td>
				           <td>' . $search->phone . '</td>
				           <td>' . $search->email . '</td>
				           <td>' . $search->userName . '</td>
				           <td>' . $search->gender . '</td>
				           <td>' . $search->dateOfBirth . '</td>
				           <td>' . $search->user_role . '</td>
				      </tr>';
			}
		}
		}
	}
 

    public function delete_user($id){

		DB::table('users')->where('id', $id)->delete();
		return redirect()->route('admin.show_users');
	}
	
	public function add_representative_view(Request $req){
		return view('home.admin.add_representative');
	}
	
	public function add_representative(Request $req){
		
		$req->validate([

            "firstName"  => "required",
            "lastName"  => "required",
            "phone"  => "required",
            "email"  => "required | unique:users,email",
            "userName"  => "required | unique:users,userName",
            "password"  => "required",
            "gender"  => "required",
            "dateOfBirth"  => "required",
            "user_role"  => "required",

        ]);
		
		DB::table('users')->insert(
    ['firstName' => $req->firstName,'lastName' => $req->lastName,'phone' => $req->phone, 'email' => $req->email,'userName' => $req->userName, 'password' => $req->password,'gender' => $req->gender,'dateOfBirth' => $req->dateOfBirth,'user_role' => $req->user_role]
    );
        return redirect()->route('admin.show_users');
	}
	
	public function show_contact(Request $req){
		return view('home.admin.contact');
	}
	
	public function add_contact(Request $req){
		
		$req->validate([

            "email"     => "required",
            "subject"  => "required",
            "message"  => "required",

        ]);
		
		$username_sess=session('username');
		$email_sess=session('email');
		DB::table('inbox')->insert(
    ['userName' => $username_sess,'subject' => $req->subject,'email_from' => $email_sess, 'email_to' => $req->email,'message' => $req->message]
    );
        echo "successfull";
	}
	
	public function inbox(){
		$email_sess=session('email');
		$data = DB::table('inbox')->where('email_to', $email_sess)->orderBy('inbox_id', 'DESC')->get();
		//echo $data;
		return view('home.admin.inbox', ['user'=>$data]);
	}
	
	public function delete_message($id){

		DB::table('inbox')->where('inbox_id', $id)->delete();
		return redirect()->route('admin.inbox');
	}
	
}
