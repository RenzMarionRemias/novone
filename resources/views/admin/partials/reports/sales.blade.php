@extends('admin.main') @include('admin.partials.sidebar')
<div class='col-xs-12 col-sm-10 col-md-10 pull-right' style='padding-left:80px;'>

    <div class="tab-content">
        <h4>Reports</h4>
        <div class='col-xs-12 col-sm-6 col-md-4'>
        Filter
        <div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
            <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
            <span></span> <b class="caret"></b>
        </div>
            <canvas id="monthlySalesChart" style="width:70px !important;height:70px !important;"></canvas>
    </div>
</div>