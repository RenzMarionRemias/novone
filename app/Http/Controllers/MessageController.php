<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Message;
use App\Notification;
use App\User;

use Carbon;
use DB;
use Redirect;
use Session;


class MessageController extends Controller {

    //ADMIN 

    public function showAdminMessageBoard(Request $request) {
        $messages = null;
        $clients = DB::table('clients')
                    ->where('client_status',1)
                    ->get()
                    ->toArray();

        $clientId = $request->query('clientId') ? $request->query('clientId') : null;

        if($clientId){
            $messages =  DB::select(DB::raw("SELECT messages.*
                FROM messages
                WHERE  (messages.sender_type='CLIENT' OR messages.sender_type='ADMIN') AND 
                (messages.sender = ".$clientId." OR messages.recipient = ".$clientId.")
                ORDER BY messages.message_id ASC
                "));

        }

        return view('admin.partials.messages.inbox',[
                    'clients'  => $clients,
                    'messages' => $messages,
                    'currentClientId' => $clientId
            ]);   
        

    }

    public function sendMessage(Request $request) {

        $userInfo = null;
        $clientController = new ClientController;
        $adminController = new AdminController;
        $msg = new Message;
        if( $request->senderType == 'ADMIN'){
            $userInfo = $clientController->getClientInformation($request->recipient);
            $adminInfo = $adminController->getUserInformation($request->sender);
            $msg->sender_name = $adminInfo->firstname." ".$adminInfo->lastname;
            $msg->recipient = $userInfo->client_id;
        }
        else{
            $clientController = new ClientController;
            $userInfo = $clientController->getClientInformation($request->sender);
            $msg->sender_name = $userInfo->firstname." ".$userInfo->lastname;
            $msg->recipient = 1;
        }

        if($userInfo){
            
            
            $msg->sender = $request->sender;
            
            $msg->sender_type = $request->senderType;
            
            
            
            $msg->message = $request->message;
    
            $msg->save();
        }
        return response()->json([
                'success'=>true,
                'data'=>$request->all()
        ]);
    }

    
    public function getMessage(Request $request){

        
        $userId = $request->query('userId');

        $result =  DB::select(DB::raw("SELECT messages.*
                    FROM messages
                    WHERE  (messages.sender_type='CLIENT' OR messages.sender_type='ADMIN') AND 
                    (messages.sender = ".$userId." OR messages.recipient = ".$userId.")
                    ORDER BY messages.message_id ASC
                    "));
        return response()->json($result);
    }
    
}