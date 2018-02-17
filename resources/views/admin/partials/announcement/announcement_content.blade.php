@extends('admin.main') @include('admin.partials.sidebar')
<div class="container" style="margin-left:200px;">
    <div class='col-xs-12 col-sm-10 col-md-5 ' style=';'>

        @if(Session::has('success'))
        <div class="alert alert-success">
            Announcement has been saved successfully! @php Session::forget('success'); @endphp
        </div>
        @endif

        <form class="form-inline" action='/novone/public/admin/announcement' method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <fieldset>
                <div id="legend">
                    @if(isset($_GET['id']))
                    <legend class="">Update an Announcement</legend>
                    @else
                    <legend class="">Update an Announcement</legend>
                    @endif
                </div>
                @if(isset($_GET['id']))
                <a href="/novone/public/admin/announcement/list">Back to Announcement List</a>
                <br/>
                <input type="hidden" name="selected_announcement_id" value="{{$_GET['id']}}" /> @endif
                <div class="control-group">
                    <label class="control-label" for="content_title" required>Content Title</label>
                    <div class="controls">
                        <input type="text" id="content_title" name="content_title" placeholder="" @if(isset($content->content_title)) value="{{$content->content_title}}" @endif class="form-control input-xlarge">
                    </div>
                </div>
                <br/>
                <div class="control-group">
                    <label class="control-label" for="content_description">Content Description</label>
                    <div class="controls">
                        <textarea id="content_description" required name="content_description" rows="5" cols="55" placeholder="" class="form-control input-xlarge">@if(isset($content->content_description)){{$content->content_description}}@endif</textarea>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="content_description">Set as Active</label>
                    <div class="controls">
                        <input type="checkbox" name="announcement_status" @if(isset($content->announcement_status)) checked @endif /> Announcement Status
                    </div>
                </div>
                <br/>
                <button class="btn btn-success pull-left" style="margin-right:62px;width:100%;text-align:center;">Save</button>
    </div>
    </fieldset>
    </form>
</div>
</div>