@extends('master')
@section("content")
<div class="panel-header" style="padding-bottom: 5%;">

   <h3 style="color: white;padding:3%"><strong> Welcome to <span style="color: #f86f06;">V</span>MOmanage</strong></h3>
</div>

<div class="content">
    <div class="row">


        @role('Super_Admin')


        <div class="col-lg">
            <div class="card ms card-chart">
                <div class="card-header">

                </div>
                <div class="card-body">

                    <div>
                        <h1 style="margin-bottom: 0px;"> {{$admin}}</h1>
                        <h6 style="margin-bottom: 0px;">Active Admin</h6>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        <i class="now-ui-icons loader_refresh spin"></i> Updated
                    </div>
                </div>
            </div>
        </div>


        @endrole
        @can('Fresher management')
        <!-- new fresher this month -->
        <div class="col-lg">
            <div class="card card-chart ms">
                <div class="card-header">

                </div>
                <div class="card-body">

                    <div>
                        <h1 style="margin-bottom: 0px;"> {{$fresher}}</h1>
                        <h6 style="margin-bottom: 0px;">Active Fresher</h6>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        <i class="now-ui-icons loader_refresh spin"></i> Updated
                    </div>
                </div>
            </div>
        </div>

        @endcan

        @can('Report management')
        <!-- new fresher this month -->
        <div class="col-lg">
            <div class="card card-chart ms">
                <div class="card-header">

                </div>
                <div class="card-body">

                    <div>
                        <h1 style="margin-bottom: 0px;"> {{$report}}</h1>
                        <h6 style="margin-bottom: 0px;">Today Report</h6>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        <i class="now-ui-icons loader_refresh spin"></i> Updated
                    </div>
                </div>
            </div>
        </div>

        @endcan

        @can('Timesheet management')
        <!-- new fresher this month -->
        <div class="col-lg">
            <div class="card card-chart ms">
                <div class="card-header">

                </div>
                <div class="card-body">

                    <div>
                        <h1 style="margin-bottom: 0px;"> {{$request}}</h1>
                        <h6 style="margin-bottom: 0px;">Pending Report</h6>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        <i class="now-ui-icons loader_refresh spin"></i> Updated
                    </div>
                </div>
            </div>
        </div>

        @endcan





    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card  card-tasks">
                <div class="card-header ">
                    <h5 class="card-category">Backend development</h5>
                    <h4 class="card-title">Fresher chart</h4>
                </div>
                <div class="card-body ">

                <figure class="highcharts-figure">
        <div id="container" ></div>
    </figure>
                </div>
                <div class="card-footer ">
                    <hr>

                </div>
            </div>
        </div>

    </div>
</div>
<script>
$(document).ready(function () {
  $(".nav1 li").removeClass("active");//this will remove the active class from  
                                     //previously active menu item 
  $('#dashboard_nav').addClass('active');
  //for demo
  //$('#demo').addClass('active');
  //for sale 
  //$('#sale').addClass('active');
});
    var x = 7;
    Highcharts.chart('container', {

        title: {
            text: 'New Fresher '},

        

        yAxis: {
            title: {
                text: 'Freshers'
            }
        },

        xAxis: {
            accessibility: {
                rangeDescription: 'Range: 1 to 12'
            },
            title: {
                text: 'Month'
            }
        },

        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle'
        },

        plotOptions: {
            series: {
                label: {
                    connectorAllowed: false
                },
                pointStart: 1
            }
        },

        series: [{

            name: 'New freshers in the month ',
            data: [<?php echo $list[1];?>, <?php echo $list[2];?>,<?php echo $list[3];?>,<?php echo $list[4];?>,<?php echo $list[5];?>,<?php echo $list[6];?>,<?php echo $list[7];?>,<?php echo $list[8];?>,<?php echo $list[9];?>,<?php echo $list[10];?>,<?php echo $list[11];?>,<?php echo $list[12];?>]
        }],

        responsive: {
            rules: [{
                condition: {
                    maxWidth: 500
                },
                chartOptions: {
                    legend: {
                        layout: 'horizontal',
                        align: 'center',
                        verticalAlign: 'bottom'
                    }
                }
            }]
        }

    });
</script>
@endsection