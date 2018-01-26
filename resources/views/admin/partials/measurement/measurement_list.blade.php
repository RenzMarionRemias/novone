@extends('admin.main') @include('admin.partials.sidebar')
<div class='col-xs-12 col-sm-10 col-md-10 pull-right' style='padding-left:100px;'>

    @if(Session::has('success'))
    <div class="alert alert-success">
        Measurement has been updated successfully! @php Session::forget('success'); @endphp
    </div>
    @endif
    <a href="#" class="btn btn-primary btn-new-measurement pull-right" data-toggle="modal" data-target="#measurementModal">New</a> 

    <ul class="nav nav-tabs" style='margin-bottom:20px;'>
        <li class="active">
            <a data-toggle="tab" href="#measurement">Measurement List</a>
        </li>

    </ul>

    <div class="tab-content">
        <div id="measurement" class="tab-pane fade in active">
            <table class="table list-data">
                <thead>
                    <tr>
                        <th>Measurement Name</th>   
                        <th>Status</th>
                        <th>Added by</th>
                        <th>Date Added</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($measurements as $measurement)
                    <tr>
                        <td>{{$measurement->measurement_name}}</td>
                        <td>{{$measurement->measurement_status}}</td>
                        <td>{{$measurement->email}}</td>
                        <td>{{$measurement->created_at}}</td>
                        <td>
                        <a href="#" class="btn btn-primary btn-edit-measurement" data-measurementid="{{$measurement->measurement_id}}" data-measurementname="{{$measurement->measurement_name}}" data-toggle="modal" data-target="#editMeasurementInfo">Edit</a> 

                        @if($measurement->measurement_status == 'ACTIVE')
                            <a href="/novone/public/admin/measurement/inactive/{{$measurement->measurement_id}}" class="btn btn-danger">Set as inactive</a>
                        @else
                            <a href="/novone/public/admin/measurement/active/{{$measurement->measurement_id}}" class="btn btn-primary">Set as active</a>
                        @endif
                         </td>
                    </tr>
                    @endforeach
                </tbody>
        </div>

    </div>


</div>




<div class="modal fade" id="measurementModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
                        <span class="sr-only">Close</span>
                    </button>
                    <h3 class="modal-title" id="lineModalLabel">New Measurement</h3>
                </div>
                <form action='/novone/public/admin/measurement/new' method='post'>
                    <div class="modal-body">
    
                        <!-- content goes here -->
                        {{ csrf_field() }}
    
                        <div class="form-group">
                            <label>Measurement Name</label>
                            <input type="text" class="form-control" required id='measurementName' name="measurement_name">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group btn-group-justified" role="group" aria-label="group button">
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-default" data-dismiss="modal" role="button">Close</button>
                            </div>
                            <div class="btn-group btn-delete hidden" role="group">
                                <button type="button"  class="btn btn-default btn-hover-red" data-dismiss="modal" role="button">Delete</button>
                            </div>
                            <div class="btn-group" role="group">
                                <button type="submit" id="Submit" class="btn btn-success btn-hover-green" data-action="save" role="button">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
    
            </div>
        </div>
    </div>



<div class="modal fade" id="editMeasurementInfo" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
                        <span class="sr-only">Close</span>
                    </button>
                    <h3 class="modal-title" id="lineModalLabel">Update Measurement Info</h3>
                </div>
                <form action='/novone/public/admin/measurement/update' method='post'>
                    <div class="modal-body">
    
                        <!-- content goes here -->
                        {{ csrf_field() }}
                        <input type="hidden" class="hiddenMeasurementId" name="measurement_id"/>
                        <div class="form-group">
                            <label>Measurement Name</label>
                            <input type="text" class="form-control" required id='editMeasurementName' name="measurement_name">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group btn-group-justified" role="group" aria-label="group button">
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-default" data-dismiss="modal" role="button">Close</button>
                            </div>
                            <div class="btn-group btn-delete hidden" role="group">
                                <button type="button"  class="btn btn-default btn-hover-red" data-dismiss="modal" role="button">Delete</button>
                            </div>
                            <div class="btn-group" role="group">
                                <button type="submit" id="Submit" class="btn btn-success btn-hover-green" data-action="save" role="button">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
    
            </div>
        </div>
    </div>