<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Cart;
use App\Invoice;
use App\InvoiceDetail;
use App\Notification;
use App\Product;
use App\TransactionInstallment;
use App\User;

use Carbon;
use DB;
use Redirect;
use Storage;
use Session;


class NotificationController extends Controller {

    public function createNotification($userId,$userType,$notifType,$message) {

        

        $notif = new Notification;
        
        $notif->user_id = $userId;

        $notif->user_type = $userType;

        $notif->notif_type = $notifType;

        $notif->message = $message;

        $notif->save();

    }

    public function getNotification($userId){

        $result =  DB::table('notifications')
                    ->where('user_id',$userId)
                    ->orderBy('created_at','DESC')
                    ->select('notifications.*')
                    ->get();

        return response()->json($result);
    }
}