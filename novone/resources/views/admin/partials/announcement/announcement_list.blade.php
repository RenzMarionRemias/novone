@extends('admin.main') @include('admin.partials.sidebar')



<div class='col-xs-12 col-sm-10 col-md-10 pull-right' style='padding-left:100px;'>
    <h1>Announcement</h1>
    @if(Session::has('success'))
    <div class="alert alert-success">
        Customer has been approved successfully! @php Session::forget('success'); @endphp
    </div>
    @endif


    <ul class="nav nav-tabs" style='margin-bottom:20px;'>
        <li class="active">
            <a data-toggle="tab" href="#active">Active</a>
        </li>
        <li>
            <a data-toggle="tab" href="#inactive">Inactive</a>
        </li>
    </ul>

    <div class="tab-content">
        <div id="active" class="tab-pane fade in active">
            <table class="table list-data">
                <thead>
                    <tr>
                        <th>Annonuncement Title</th>
                        <th>Posted by</th>
                        <th>Date Posted</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($announcements as $a) @if($a->announcement_status == 1)
                    <tr>
                        <td>{{$a->content_title}}</td>
                        <td>{{$a->email}}</td>
                        <td>{{$a->created_at}}</td>
                        <td>
                            <a href="/novone/public/admin/announcement?id={{$a->announcement_id}}" class="btn btn-primary">Edit Content</a>
                            <a href="/novone/public/admin/announcement/update/{{$a->announcement_id}}?action=INACTIVE" class="btn btn-danger">Set as Inactive</a>
                        </td>
                    </tr>
                    @endif @endforeach

                </tbody>
            </table>
        </div>

        <div id="inactive" class="tab-pane fade in">
            <table class="table list-data">
                <thead>
                    <tr>
                        <th>Annonuncement Title</th>
                        <th>Posted by</th>
                        <th>Date Posted</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($announcements as $a) @if($a->announcement_status == 0)
                    <tr>
                        <td>{{$a->content_title}}</td>
                        <td>{{$a->email}}</td>
                        <td>{{$a->created_at}}</td>
                        <td>
                            <a href="/novone/public/admin/announcement?id={{$a->announcement_id}}" class="btn btn-primary">Edit Content</a>
                            <a href="/novone/public/admin/announcement/update/{{$a->announcement_id}}?action=ACTIVE" class="btn btn-success">Set as Active</a>
                        </td>
                    </tr>
                    @endif @endforeach
                </tbody>
            </table>
        </div>

    </div>

</div>
