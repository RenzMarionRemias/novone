<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Client;

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

    public function clientApprove($id,Request $request){
        Client::where('client_id',  $request->clientId)->update(['client_status' => $id]);
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
                return redirect()->back();
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
            'middlename'       => 'required|max:30',
            'email'            => 'required|max:30|unique:clients',
            'contact_no'       => 'required|max:15',
            'business_name'    => 'required|max:30',
            'business_address' => 'required|max:30',
            'business_contact' => 'required|max:15'
        ]);

        $functions = new \App\Library\Functions;

        $generatedPassword = $functions->generateRandomString(10);

        $clientImage = Storage::disk('local')->put('clients', $request->client_photo);
        $client = new Client;
        
        $client->email            = $request->email;
        $client->password         = $generatedPassword;
        $client->lastname         = $request->lastname;
        $client->firstname        = $request->firstname;
        $client->middlename       = $request->middlename;
        $client->client_photo     = $clientImage;
        $client->gender           = $request->gender;
        $client->birthdate        = $request->birthdate;
        $client->contact_no       = $request->contact_no;
        $client->business_name    = $request->business_name;
        $client->business_address = $request->business_address;
        $client->business_contact = $request->business_contact;

        $client->save();

        return redirect()->back()->with('success',true);
    }
}