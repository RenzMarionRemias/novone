<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

use App\Announcement;
use App\User;
use DB;
use Storage;
use Session;

class AnnouncementController extends Controller {


    public function showAnnouncement(Request $request) {
        $announcementId = $request->query('id');

        $content = DB::table('announcements')
                    ->where('announcements.announcement_id',$announcementId)
                    ->select('announcements.*')
                    ->get()
                    ->toArray();
        
        if(!$content){
            $content = null;
        }
        else{
            $content = $content[0];
        }

        return view('admin.partials.announcement.announcement_content',[
            'content' => $content
        ]);
    }

    public function showAnnouncementList() {
        $announcement = DB::table('announcements')
                        ->leftJoin('users','users.id','announcements.user_id')
                        ->select('announcements.*','users.email')
                        ->get()
                        ->toArray();

        return view('admin.partials.announcement.announcement_list',[
            'announcements' => $announcement
        ]);
    }

    public function submitAnnouncement(Request $request){
        //session()->get('currentUser')->id;

        $status = isset($request->announcement_status) ? 1 : 0;
        if(isset($request->selected_announcement_id)){
            
            Announcement::where('announcement_id', $request->selected_announcement_id)
                    ->update(['content_title' =>  $request->content_title,
                            'content_description' =>  $request->content_description,
                            'announcement_status' => $status
                            ]);
        }
        else{
            $announcement = new Announcement;
            
            $announcement->user_id = session()->get('currentUser')->id;

            $announcement->announcement_status = $status;
    
            $announcement->content_title = $request->content_title;
    
            $announcement->content_description = $request->content_description;
    
            $announcement->save();
        }

        return redirect()->back()->with('success',true);
    }

    public function updateAnnouncementStatus($id,Request $request){
        $action = $request->query('action');
        $status = 0;
        if($action == 'ACTIVE') {
            $status = 1;
        }
        else if($action == 'INACTIVE'){
            $status = 0;
        }

        if($action == 'ACTIVE' || $action == 'INACTIVE'){
            Announcement::where('announcement_id', $id)
            ->update(['announcement_status' => $status]);
    
            return redirect()->back()->with('success',true);
        }
            return redirect()->back()->with('failed',true);
    }

    public function showAnnouncementClient(){
        
        $content = DB::table('announcements')
                    ->where('announcement_status',1)
                    ->select('announcements.*')
                    ->get()
                    ->toArray();

        if(!$content){
            $content = null;
        }
        return view('home.partials.announcement.announcement',[
            'content' => $content
        ]);
    }
}