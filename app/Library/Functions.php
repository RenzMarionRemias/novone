<?php

namespace App\Library;

class Functions {
    

    public function generateRandomString($num) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $num; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function prepareSessionObject ($user,$type){
        
        $session = [];

        $session['id']               = $type == 'CLIENT' ? $user->client_id : $user->id;
        $session['email']            = $user->email;
        $session['lastname']         = $user->lastname;
        $session['firstname']        = $user->firstname;
        $session['middlename']       = $user->middlename;
        $session['client_photo']     = $user->client_photo;
        $session['client_type']      = $user->client_type;
        $session['gender']           = $user->gender;
        $session['birthdate']        = $user->birthdate;
        $session['contact_no']       = $user->contact_no;
        $session['business_name']    = $user->business_address;
        $session['business_address'] = $user->business_address;
        $session['business_contact'] = $user->business_contact;

        return $session;
    }
}
