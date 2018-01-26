<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;


use App\Measurement;
use App\User;
use DB;
use Storage;
use Session;

class MeasurementController extends Controller {

	public function showMeasurement() {


		$measurements = DB::table('measurements')
						->leftJoin('users','measurements.user_id','=','users.id')
        				->where('measurements.measurement_status', 'ACTIVE')
        				->select('measurements.*','users.email')
        				->get()
        				->toArray();

        return view('admin.partials.measurement.measurement_list',[
            'measurements'=>$measurements
        ]);

	}

	public function saveNewMeasurement(Request $request){

		$request->validate([
            'measurement_name'  => 'required|unique:measurements'
        ]);
		 
		$measurement = new Measurement;

		$measurement->measurement_name = ucfirst($request->measurement_name);

		$measurement->measurement_status = 'ACTIVE';

		$measurement->user_id = session()->get('currentUser')->id;

		$measurement->save();

		return redirect()->back()->with('success',true);
	}

	public function updateMeasurementStatus($action,$id){

        Measurement::where('measurement_id',$id)
            ->update(['measurement_status' => strtoupper($action)]);

        return redirect()->back()->with('success',true);
	}

	public function updateMeasurementInfo(Request $request){
		
		$request->validate([
            'measurement_name'  => 'required|unique:measurements'
        ]);

		 Measurement::where('measurement_id',$request->measurement_id)
            ->update(['measurement_name' => $request->measurement_name]);

         return redirect()->back()->with('success',true);
	}

	public function getMeasurementList(){
		
		return DB::table('measurements')
        		->where('measurement_status', 'ACTIVE')
        		->get()
        		->toArray();
	}

}

