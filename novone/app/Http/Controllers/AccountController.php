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

            $accountType->save();

            return redirect()->back()->with('success',true);
	}

	public function updateAccountStatus($action,$id,Request $request){

        AccountType::where('account_type_id', $id)
            ->update(['account_type_status' => strtoupper($action)
        ]);
        return redirect()->back()->with('delete',true); 
	}

	// EDIT ACCESS RIGHTS

	public function showAccessRights($id,Request $request){

		$accountType = DB::table('account_types')
				->where('account_type_id',$id)
				->get()
				->toArray();
		
		if($accountType){
			return view('admin.partials.account.access_rights',[
				'accountTypeId' => $accountType[0]->account_type_id,
				'module_invoice' => $accountType[0]->module_invoice,
				'module_products'=> $accountType[0]->module_products,
				'module_maintenance'=> $accountType[0]->module_maintenance,
				'module_clients'=> $accountType[0]->module_clients,
				'module_users'=> $accountType[0]->module_users,
				'module_inventory'=> $accountType[0]->module_inventory,
				'module_message'=> $accountType[0]->module_message,
				'module_store'=> $accountType[0]->module_store,
				'module_category'=> $accountType[0]->module_category,
				'module_measurement'=> $accountType[0]->module_measurement,
				'module_logs'=> $accountType[0]->module_logs,
				'module_reports'=> $accountType[0]->module_reports,
			]);   
		}
		return redirect()->back(); 
	}

	public function updateAccessRights($id,Request $request){

		AccountType::where('account_type_id', $id)
			->update([
			'module_invoice' => isset($request->module_invoice) ? 1 : 0,
			'module_products'=> isset($request->module_products) ? 1 : 0,
			'module_maintenance'=> isset($request->module_maintenance) ? 1 : 0,
			'module_clients'=> isset($request->module_clients) ? 1 : 0,
			'module_users'=> isset($request->module_users) ? 1 : 0,
			'module_inventory'=> isset($request->module_inventory) ? 1 : 0,
			'module_message'=> isset($request->module_message) ? 1 : 0,
			'module_store'=> isset($request->module_store) ? 1 : 0,
			'module_category'=> isset($request->module_category) ? 1 : 0,
			'module_measurement'=> isset($request->module_measurement) ? 1 : 0,
			'module_logs'=> isset($request->module_logs) ? 1 : 0,
			'module_reports'=> isset($request->module_reports) ? 1 : 0,
		]);

		return redirect()->back()->with('updateSuccess',true); 
		
	}
}
