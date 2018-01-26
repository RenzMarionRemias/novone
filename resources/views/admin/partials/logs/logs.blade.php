@extends('admin.main') @include('admin.partials.sidebar')
<div class='col-xs-12 col-sm-10 col-md-10 pull-right' style='padding-left:100px;'>
    <ul class="nav nav-tabs" style='margin-bottom:20px;'>
        <li class="active">
            <a data-toggle="tab" href="#home">User Logs</a>
        </li>
        <li>
            <a data-toggle="tab" href="#details">Audit Trail</a>
        </li>
    </ul>

    <div class="tab-content">
        <div id="sales" class="tab-pane fade in active">
            <table class="table list-data">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Email</th>
                        <th>Time Login</th>
                        <th>Time Logout</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($userLogs as $log)
                        <tr>
                            <td>{{$log->id}}</td>
                            <td>{{$log->email}}</td>
                            <td>{{$log->time_login}}</td>
                            <td>{{$log->time_logout}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>