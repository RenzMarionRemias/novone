@extends('admin.main') @include('admin.partials.sidebar')
<div class='col-xs-12 col-sm-10 col-md-10 pull-right' style='padding-left:100px;'>

    <div class="col-xs-12 col-sm-4 col-md-3" style="min-height:400px !important;max-height:400px !important;overflow-y:scroll !important;">
        <h4>List of clients</h4>
        @foreach($clients as $client)
        <a href="/novone/public/admin/messages/client?clientId={{$client->client_id}}">
            <div class="col-xs-12 col-sm-12 col-md-12 alert alert-info">
                {{strtoupper($client->firstname)}} {{strtoupper($client->lastname)}}<br/>
                {{$client->email}}
            </div>
        </a>
        @endforeach
    </div>

    <h4>Messages</h4>
    @if(isset($messages))
    <div class="col-xs-12 col-sm-8 col-md-9">
        <div class="col-xs-12 col-sm-12 col-md-12" id="adminMessageThread" style="min-height:400px !important;max-height:400px !important;overflow-y:scroll !important;">
            @if(isset($messages)) @foreach($messages as $message)
            <div class="col-xs-12 col-sm-12 col-md-12 alert alert-success">
                <h4>{{$message->sender_name}}</h4>
                {{$message->message}}
                <br/>
                <i>{{$message->created_at}}</i>
            </div>
            @endforeach @endif
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <form id="adminMessageSubmit" method="post">
                @if($currentClientId)
                <input type="hidden" class="currentClientId" value="{{$currentClientId}}" /> @endif
                <textarea class="form-control" name="adminMessage" id="adminMessage"></textarea>
                <input type="submit" class="btn btn-primary pull-right" value="Send" />
            </form>
        </div>
    </div>
    @endif



</div>