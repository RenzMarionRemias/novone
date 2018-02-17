@include('home.index')

<div class="container">
    <div class='col-xs-12 col-sm-12 col-md-12' style='margin-top:120px;'>

        <div class="col-xs-12 col-sm-12 col-md-12" id="clientConversation" style="min-height:400px !important;max-height:400px !important;overflow-y:scroll !important">

        </div>
        <div class="form-group col-md-12">
            <label>Message</label>
            <form method="POST" id="clientSendMessage" >
                <textarea required  class="form-control" id="clientMessage"></textarea>
                <input type="submit" class="btn btn-primary pull-right" style="margin-top:20px;" value="Send" />
            </form>
        </div>

    </div>
</div>

@include('home.partials.footer')