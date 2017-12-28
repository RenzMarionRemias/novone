@extends('admin.main') @include('admin.partials.sidebar')



<div class='col-xs-12 col-sm-10 col-md-10 pull-right' style='padding-left:100px;'>
    <h1>Clients</h1>
    @if(Session::has('success'))
    <div class="alert alert-success">
        Client has been approved successfully! @php Session::forget('success'); @endphp
    </div>
    @endif


    <ul class="nav nav-tabs" style='margin-bottom:20px;'>
        <li class="active">
            <a data-toggle="tab" href="#home">Active</a>
        </li>
        <li>
            <a data-toggle="tab" href="#pendingAccounts">Pending</a>
        </li>

        <li>
            <a data-toggle="tab" href="#inactiveAccounts">Inactive</a>
        </li>
    </ul>

    <div class="tab-content">
        <div id="home" class="tab-pane fade in active">
            <table class="table">
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>Fullname</th>
                        <th>Status</th>
                        <th>Gender</th>
                        <th>Birthdate</th>
                        <th>Contact No.</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($clients as $client) @if($client['client_status'] == 1)
                    <tr>
                        <td>{{$client['email']}}</td>
                        <td>{{$client['lastname']}} {{$client['firstname']}} {{$client['middlename']}}</td>
                        <td>@if($client['client_status'] == 0)Pending @else Approved @endif</td>
                        <td>{{$client['gender']}}</td>
                        <td>{{$client['birthdate']}}</td>
                        <th>{{$client['contact_no']}}</th>
                        <td>
                            <a class="btn btn-info btn-sm btn-client-information" data-toggle="modal" data-target="#clientInformation" data-id="{{$client['client_id']}}"
                                data-clientstatus="{{$client['client_status']}}" data-email="{{$client['email']}}" data-lastname="{{$client['lastname']}}"
                                data-firstname="{{$client['firstname']}}" data-middlename="{{$client['middlename']}}" data-gender="{{$client['gender']}}"
                                data-birthdate="{{$client['birthdate']}}" data-contact="{{$client['contact_no']}}" data-businessname="{{$client['business_name']}}"
                                data-businessaddress="{{$client['business_address']}}" data-businesscontact="{{$client['business_contact']}}">View Full Details</a>
                        </td>
                    </tr>
                    @endif @endforeach

                </tbody>
            </table>
        </div>
        <div id="pendingAccounts" class="tab-pane fade">
            <table class="table">
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>Fullname</th>
                        <th>Status</th>
                        <th>Gender</th>
                        <th>Birthdate</th>
                        <th>Contact No.</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($clients as $client) @if($client['client_status'] == 0)
                    <tr>
                        <td>{{$client['email']}}</td>
                        <td>{{$client['lastname']}} {{$client['firstname']}} {{$client['middlename']}}</td>
                        <td>@if($client['client_status'] == 0)Pending @else Approved @endif</td>
                        <td>{{$client['gender']}}</td>
                        <td>{{$client['birthdate']}}</td>
                        <th>{{$client['contact_no']}}</th>
                        <td>
                            <a class="btn btn-info btn-sm btn-client-information" data-toggle="modal" data-target="#clientInformation" data-id="{{$client['client_id']}}"
                                data-clientstatus="{{$client['client_status']}}" data-email="{{$client['email']}}" data-lastname="{{$client['lastname']}}"
                                data-firstname="{{$client['firstname']}}" data-middlename="{{$client['middlename']}}" data-gender="{{$client['gender']}}"
                                data-birthdate="{{$client['birthdate']}}" data-contact="{{$client['contact_no']}}" data-businessname="{{$client['business_name']}}"
                                data-businessaddress="{{$client['business_address']}}" data-businesscontact="{{$client['business_contact']}}">View Full Details</a>

                        </td>
                    </tr>
                    @endif @endforeach

                </tbody>
            </table>
        </div>

        <div id="inactiveAccounts" class="tab-pane fade">
            <table class="table">
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>Fullname</th>
                        <th>Status</th>
                        <th>Gender</th>
                        <th>Birthdate</th>
                        <th>Contact No.</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($clients as $client) @if($client['client_status'] == 2)
                    <tr>
                        <td>{{$client['email']}}</td>
                        <td>{{$client['lastname']}} {{$client['firstname']}} {{$client['middlename']}}</td>
                        <td>@if($client['client_status'] == 0)Pending @else Approved @endif</td>
                        <td>{{$client['gender']}}</td>
                        <td>{{$client['birthdate']}}</td>
                        <th>{{$client['contact_no']}}</th>
                        <td>
                            <a class="btn btn-info btn-sm btn-client-information" data-toggle="modal" data-target="#clientInformation" data-id="{{$client['client_id']}}"
                                data-clientstatus="{{$client['client_status']}}" data-email="{{$client['email']}}" data-lastname="{{$client['lastname']}}"
                                data-firstname="{{$client['firstname']}}" data-middlename="{{$client['middlename']}}" data-gender="{{$client['gender']}}"
                                data-birthdate="{{$client['birthdate']}}" data-contact="{{$client['contact_no']}}" data-businessname="{{$client['business_name']}}"
                                data-businessaddress="{{$client['business_address']}}" data-businesscontact="{{$client['business_contact']}}">View Full Details</a>
                        </td>
                    </tr>
                    @endif @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

<div class="modal fade" id="clientInformation" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">×</span>
                    <span class="sr-only">Close</span>
                </button>
                <h3 class="modal-title" id="lineModalLabel">Client Information</h3>
            </div>
            <form id='approveAccountURL' method='post'>
                <div class="modal-body">

                    <!-- content goes here -->
                    {{ csrf_field() }}

                    <input type='hidden' name='clientId' id='hiddenClientId'>
                    <div class="form-group">
                        <label>Email: </label>
                        <label id="clientEmail"></label>
                    </div>
                    <div class="form-group">
                        <label>Fullname: </label>
                        <label id="clientFullName"></label>
                    </div>

                    <div class="form-group">
                        <label>Gender: </label>
                        <label id="clientGender"></label>
                    </div>

                    <div class="form-group">
                        <label>Birthdate: </label>
                        <label id="clientBirthdate"></label>
                    </div>

                    <div class="form-group">
                        <label>Business Name: </label>
                        <label id="clientBusinessName"></label>
                    </div>

                    <div class="form-group">
                        <label>Business Address: </label>
                        <label id="clientBusinessAddress"></label>
                    </div>

                    <div class="form-group">
                        <label>Business Contact No: </label>
                        <label id="clientBusinessContact"></label>
                    </div>

                </div>
                <div class="modal-footer">
                    <div class="btn-group btn-group-justified" role="group" aria-label="group button">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default" data-dismiss="modal" role="button">Close</button>
                        </div>
                        <div class="btn-group btn-delete hidden" role="group">
                            <button type="button" id="delImage" class="btn btn-default btn-hover-red" data-dismiss="modal" role="button">Delete</button>
                        </div>
                        <div class="btn-group" role="group">
                            <button type="submit" id="clientStatusSubmit" class="btn btn-primary btn-hover-green" data-action="save" role="button">Approve Account</button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>