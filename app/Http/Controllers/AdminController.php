<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AccountType;
use App\Log;
use App\User;


use DB;
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

        $pendingClients = DB::table('clients')
                            ->where('client_status',0)
                            ->get()
                            ->toArray();
        
        return view('admin.partials.dashboard',[
            'pendingClients' => count($pendingClients)
        ]);
    }

    public function submitLogin(Request $request){
        
        $user = User::where('email','=',$request->email)
                    ->where('password','=',$request->password)
                    ->where('account_status',1)->first();
        if(!$user){
            return redirect()->back()->with('loginFailed',true);
        }


        session(['currentUser' => $user]);

        $access = $this->getAccess(session()->get('currentUser')['account_type']);
        
        session(['access' => $access]);
        $this->insertLogs($user->id);
        
        return redirect('/admin/dashboard');
    }  


    public function getAccess($acccountType){
        $accountType = DB::table('account_types')
                        ->where('account_type_name',$acccountType)
                        ->get()
                        ->toArray();
        
        if($accountType){
            return $accountType[0];
        }

        return null;
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

        //$user_log->time_login = session()->get('currentUser')->id;

        $user_log->save();

    }

    public function showAccountInformation(){

        $user = $this->getUserInformation(session()->get('currentUser')->id);

        return view('admin.partials.users.update_user_information',[
            'user' => $user
        ]);
    }

    public function updateAccountInformation(Request $request){

        $request->validate([
            'lastname'  => 'required',
            'firstname' => 'required',
            'middlename' => 'required',
            'email' => 'required'
        ]);

        User::where('id', session()->get('currentUser')->id)
        ->update([
            'lastname' => $request->lastname,
            'firstname' => $request->firstname,
            'middlename' => $request->middlename,
            'email' => $request->email
        ]);

        return redirect()->back()->with('updateInformationSuccess',true);
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

    public function getUserInformation($userId) {

        $result =  DB::table('users')
                        ->where('users.id',$userId)
                        ->where('users.account_status',1)
                        ->get()
                        ->toArray();

        if($result){
            return $result[0];
        }

        return null;
    }
}
