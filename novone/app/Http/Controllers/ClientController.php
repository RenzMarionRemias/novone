<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

use App\Mail\AccountVerification;
use App\Mail\ResetPassword;
use App\Client;

use DB;
use Storage;
use Session;


class ClientController extends Controller {

    public function showHomepage(){
        return view('home.partials.home');
    }


    public function showSignup(){
        return view('home.partials.registration.signup');
    }

    public function showLogin(){
        return view('home.partials.login.signin');
    }

    public function showClients(){
        $clients = Client::all()->toArray();

        return view('admin.partials.clients.client_list', [
            'clients' => $clients
        ]);
    }

    public function showInbox(){

        return view('home.partials.messages.inbox');
    }

    public function showUserInformation(){
        $userInformation = session()->get('currentClient');

        return view('home.partials.accounts.user_info',[
            'userInformation' => $userInformation
        ]);
    }

    public function showChangeCredentials(){
        return view('home.partials.accounts.change_credentials');
    }

    public function updateEmail(Request $request){
  
        $request->validate([
            'old_email'          => 'required',
            'email'          => 'required|min:8|max:30|unique:clients',
            'repeat_new_email'   => 'required|min:8|max:30',
        ]);

        $user = $this->getOldCredentials(session()->get('currentClient')['email']);

        if($user){
            if($user->email == $request->old_email){
                if($request->email == $request->repeat_new_email){
                    Client::where('email', session()->get('currentClient')['email'])
                        ->update([
                            'email' => $request->email
                        ]);
                }
                else{
                    return redirect()->back()->with('newEmailNotMatch',true);
                }
            }   
            else{
                return redirect()->back()->with('oldEmailFailed',true);
            }

        }


        return redirect()->back()->with('success',true);
    }

    public function updatePassword(Request $request){

        $request->validate([
            'old_password'          => 'required',
            'new_password'          => 'required|min:8|max:30',
            'repeat_new_password'   => 'required|min:8|max:30',
        ]);

        $user = $this->getOldCredentials(session()->get('currentClient')['email']);

        if($user->password == $request->old_password){
            if($request->new_password == $request->repeat_new_password){
                Client::where('email', session()->get('currentClient')['email'])
                    ->update([
                        'password' => $request->new_password
                    ]);
            }
            else{
                 return redirect()->back()->with('newPasswordNotMatch',true);
            }
        }   
        else{
            return redirect()->back()->with('oldPasswordFailed',true);
        }

        return redirect()->back()->with('success',true);
    }

    public function getOldCredentials($email) {
       $user = DB ::table('clients')
                    ->where('clients.email',$email)
                    ->select('clients.email','clients.password')
                    ->get()
                    ->toArray();

        return $user ? $user[0] : null;
    }

    public function clientApprove($id,Request $request){
        set_time_limit(10000);
        $clientInformation =  DB::table('clients')
                                ->where('clients.client_id',$request->clientId)
                                ->select('clients.*')
                                ->get()
                                ->toArray();

        Client::where('client_id',  $request->clientId)
                ->update([
                    'client_status' => $id]);

        Mail::to($clientInformation[0]->email)->send(new AccountVerification($clientInformation[0]));
        return redirect()->back()->with('success',true);
    }



    public function clientSignin(Request $request){

        $functions = new \App\Library\Functions;

        $request->validate([
            'email'         => 'required',
            'password'      => 'required'
        ]);

        $client = Client::where('email','=',$request->email)
            ->where('client_status',1)
            ->where('password','=',$request->password)->first();
        
            if(!$client){
                return redirect()->back()->with('loginFailed',true);
            }

            session(['currentClient' => $functions->prepareSessionObject($client,'CLIENT')]);

            return redirect('/');
    }

    public function logout(Request $request){
        Session::forget('currentClient');
        return redirect('/');
    }

    public function clientSignup(Request $request){
    
        $request->validate([
            'lastname'         => 'required|max:30',
            'firstname'        => 'required|max:30',
            'email'            => 'required|max:30|unique:clients',
            'contact_no'       => 'required|max:15',
            'business_name'    => 'required|max:30',
            'business_address' => 'required|max:30',
            'business_contact' => 'required|max:15',
        ]);

        $functions = new \App\Library\Functions;

        $generatedPassword = $functions->generateRandomString(10);

        //$clientImage   = Storage::disk('local')->put('clients', $request->client_photo);
        //$clientValidId = Storage::disk('local')->put('client_requirements' , $request->client_valid_id);
        $client = new Client;
        
        $client->email            = $request->email;
        $client->password         = $generatedPassword;
        $client->lastname         = $request->lastname;
        $client->firstname        = $request->firstname;
        $client->middlename       = $request->middlename;
       // $client->client_photo     = $clientImage;
        $client->gender           = $request->gender;
        $client->birthdate        = $request->birthdate;
        $client->contact_no       = $request->contact_no;
        $client->business_name    = $request->business_name;
        $client->business_address = $request->business_address;
        $client->business_contact = $request->business_contact;

        $client->save();

        return redirect()->back()->with('success',true);
    }


    public function updateClientInformation(Request $request){

        $request->validate([
            'lastname'         => 'required|max:30',
            'firstname'        => 'required|max:30',
            'contact_no'       => 'required|max:15',
            'business_name'    => 'required|max:30',
            'business_address' => 'required|max:30',
            'business_contact' => 'required|max:15',
        ]);

        Client::where('client_id', session()->get('currentClient')['id'])
                ->update([
                    'lastname'          => ucfirst($request->lastname),
                    'firstname'         => ucfirst($request->firstname),
                    'middlename'        => ucfirst($request->middlename),
                    'contact_no'        => $request->contact_no,
                    'business_name'     => ucfirst($request->business_name),
                    'business_address'  => ucfirst($request->business_address),
                    'business_contact'  => $request->business_contact
        ]);

        $this->updateSessionInformation($request);
        

        return redirect()->back()->with('success',true);
    }

    public function updateSessionInformation($user){
        session(['currentClient' => [
            'id' => session()->get('currentClient')['id'],  
            'email' => session()->get('currentClient')['email'],
            'birthdate' => $user->birthdate,
            'gender' => $user->gender,
            'lastname' => $user->lastname,
            'firstname' => $user->firstname,
            'middlename' => $user->middlename,
            'contact_no' => $user->contact_no,
            'business_name' => $user->business_name,
            'business_address' => $user->business_address,
            'business_contact' => $user->business_contact
        ]]);
    }

    public function changeAccountType($id,Request $request){

        $action = strtoupper($request->query('type'));

            if($action != "OLD" && $action != "NEW"){
                    return redirect()->back()->with('error',true);
            }
        
            Client::where('client_id', $id)
                ->update([
                    'client_type' => $action
            ]);
        
            return redirect()->back()->with('success',true);
    }

    public function getClientInformation($userId){
        
        $result =  DB::table('clients')
                    ->where('clients.client_id',$userId)
                    ->select('clients.*')
                    ->get()
                    ->toArray();

        if($result){

            return $result[0];
        }

        return null;
    }

    public function showForgotPassword() {
        return view('home.partials.login.forgot_password');
    }

    public function forgotPasswordSubmit(Request $request) {

        $user = DB ::table('clients')
                    ->where('clients.email',$request->email)
                    ->select('clients.email','clients.password')
                    ->get()
                    ->toArray();
        
        if($user) {
            Mail::to($user[0]->email)->send(new ResetPassword($user[0]));
            
            return redirect()->back()->with('forgotPasswordSuccess',true);  
        }

        return redirect()->back()->with('accountNotExist',true);  

    }


}