<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

use App\Mail\AccountVerification;

use App\AccountType;
use App\User;
use DB;
use Storage;
use Session;

class AccountController extends Controller {

	public function createAccountType() {
		$accountType = AccountType::all()->toArray();

		return view('admin.partials.account.create',[
			'accountType' => $accountType
		]);   
	}

	public function saveAccountType(Request $request){
			
		    $accountType = new AccountType;

		    $accountType->account_type_name = $request->account_type_name;

		   	if(isset($request->module_products)){
		   		$accountType->module_products = 1;
		   	} 

		   	if(isset($request->module_inventory)){
		   		$accountType->module_inventory = 1;
		   	} 

		   if(isset($request->module_invoice)){
		   		$accountType->module_invoice = 1;
		   } 

		   if(isset($request->module_maintenance)){
		   		$accountType->module_maintenance = 1;
		   } 

		   	if(isset($request->module_clients)){
		   		$accountType->module_clients = 1;
		   } 

		   	if(isset($request->module_users)){
		   		$accountType->module_users = 1;
		   } 

            $accountType->save();

            return redirect()->back()->with('success',true);
	}

	public function updateAccountStatus($action,$id,Request $request){

        AccountType::where('account_type_id', $id)
            ->update(['account_type_status' => strtoupper($action)
        ]);
        return redirect()->back()->with('delete',true); 
	}
}
