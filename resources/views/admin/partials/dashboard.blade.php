@extends('admin.main') @include('admin.partials.sidebar')
<div class='col-xs-12 col-sm-10 col-md-10 pull-right' style='padding-left:40px;'>

    <div class="col-xs-12 col-sm-12 col-md-12" style="padding:0px;margin:0px;">
    <div class="col-xs-12 col-sm-6 col-md-4" style="padding:0px;margin:0px;">
        <h5 style="font-weight:bolder;font-size:18px;">List of critical level products</h5>
        <div class="col-xs-12 col-sm-12 col-md-12 alert alert-danger" id="criticalProductDiv">

        </div>
    </div>

    @if($pendingClients > 0)
    <div class="col-xs-12 col-sm-6 col-md-4" style="padding:0px;margin:0px;">
        <h5 style="font-weight:bolder;font-size:18px;">Clients</h5>
        <div class="col-xs-12 col-sm-12 col-md-12 alert alert-info" id="pendingClients">
            <b>There are {{$pendingClients}} pending clients!</b>
            @if(isset(Session::get('access')->module_clients) || Session::get('currentUser')->account_type == 'SUPER_ADMIN')
            <a href="/novone/public/admin/client/list">Click Here!</a>
            @endif
        </div>
    </div>
    @endif

    </div>
    <br/>
    <div class="col-xs-12 col-sm-10 col-md-3">
        <h5 style="font-weight:bolder;">Sales for the last 7 days</h5>
        <canvas id="salesChart" style="width:70px !important;height:70px !important;"></canvas>
    </div>

    <div class="col-xs-12 col-sm-10 col-md-3">
        <h5 style="font-weight:bolder;">Monthly Sales</h5>
        <canvas id="monthlySalesChart" style="width:70px !important;height:70px !important;"></canvas>
    </div>

    <div class="col-xs-12 col-sm-10 col-md-3">
            <h5 style="font-weight:bolder;">No. of Client Register Monthly</h5>
            <canvas id="clientMonthlyRegisterChart" style="width:70px !important;height:70px !important;"></canvas>
    </div>

    <div class="col-xs-12 col-sm-10 col-md-3">
            <h5 style="font-weight:bolder;">Top Products</h5>
            <canvas id="topProducts" style="width:70px !important;height:70px !important;"></canvas>
    </div>
</div>