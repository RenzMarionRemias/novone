<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;


use App\Log;
use App\User;
use DB;
use Storage;
use Session;

class LogsController extends Controller {

	public function showUserLogs() {

		$userLogs = DB::table('logs')
        ->leftJoin('users', 'logs.user_id', '=', 'users.id')
        ->select('logs.*','users.email')
        ->get();

        return view('admin.partials.logs.logs',[
            'userLogs' => $userLogs
        ]);
	}
}