<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AccountType;
use App\Log;
use App\User;

use Session;

class AdminController extends Controller
{
    //

    public function adminLogin(){

        if(session()->get('currentUser')){
            return redirect('/admin/dashboard');
        }
        return view('admin.partials.login');
    } 

    public function showDashboard(){
        if(!session()->get('currentUser')){
            return redirect('/admin');
        }
        return view('admin.partials.dashboard');
    }

    public function submitLogin(Request $request){
        
        $user = User::where('email','=',$request->email)
                    ->where('password','=',$request->password)->first();
        if(!$user){
            return redirect()->back();
        }

        session(['currentUser' => $user]);

        $this->insertLogs($user->id);
        
        return redirect('/admin/dashboard');
    }  

    public function showCreateUsers(){

        $accountType = AccountType::all()->toArray();

        return view('admin.partials.users.create_user',[
            'accountType' => $accountType
        ]);
    }

    public function showUsers(){
        $users = User::all()->toArray();
        $accountType = AccountType::all()->toArray();

        return view('admin.partials.users.user_list', [
            'accountType'   => $accountType,
            'users'         => $users,
            'currentUserId' => session()->get('currentUser')->id
        ]);
    }

    public function createUser(Request $request){

        $request->validate([
            'lastname'  => 'required|max:30|alpha',
            'firstname' => 'required|max:30|alpha',
            'middlename' => 'alpha',
            'email'     => 'required|unique:users',
            'password' =>  'required|min:8||max:30',
        ]);
        $user = new User;

        $user->account_type = $request->account_type;

        $user->lastname = $request->lastname;

        $user->firstname = $request->firstname;

        $user->middlename = $request->middlename;

        $user->email = $request->email;

        $user->password = $request->password;

        $user->save();

        return redirect()->back()->with('success',true);
    }

    public function updateUser(Request $request){
        $req = $request->all();

        User::where('email', $request->currentEmail)
            ->update(['lastname' => $request->editLastname,
            'firstname' => $request->editFirstname,
            'middlename' => $request->editMiddlename,
            'email' => $request->editEmail,
            'account_type' => $request->account_type,
        ]);

        return redirect()->back()->with('success', true);;;
    }
    
    public function updateUserStatus($status,$userId){
        
        $statusValue = $status == 'inactive' ? 0 : 1;
        User::where('id',$userId)
            ->update(['account_status' => $statusValue]);

        return redirect()->back();

    }


    public function logoutUser(){
        session()->flush();
        return redirect('/admin');
    }


    public function insertLogs($userId){

        $user_log = new Log;

        $user_log->user_id = session()->get('currentUser')->id;

        $user_log->save();

    }

    public function showChangePassword(){
        return view('admin.partials.users.update_user_password');
    }

    public function saveNewPassword(Request $request){


        $request->validate([
            'old_password'  => 'required',
            'new_password' => 'required|max:30',
            'repeat_new_password' => 'required'
        ]);

        User::where('id', session()->get('currentUser')->id)
        ->update(['password' => $request->new_password
        ]);
    }
}
