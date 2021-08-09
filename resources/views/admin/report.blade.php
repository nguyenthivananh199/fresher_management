@extends('master')
@section("content")
<!-- modal box -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div style="text-align: center;margin-top:4%;" class="">
                <h4>Report detail</h4>
                <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
            </div>
            <div class="modal-body" id="detail">

            </div>

        </div>

    </div>
</div>
<!-- ------------- -->
<div class="panel-header panel-header-sm">
</div>
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">

                    <div class="row">


                        <!-- <button onclick="preClick(0);">pre</button> -->
                        <div class="col change-month" style="text-align: right;">
                            <i onclick="preClick(0);" class="now-ui-icons arrows-1_minimal-left"></i>
                        </div>
                        <h4 class="col " id="month_now" style="text-align: center;"></h4>
                        <div class="col change-month" style="text-align: left;">
                            <i onclick="preClick(1);" class="now-ui-icons arrows-1_minimal-right"></i>
                        </div>
                    </div>
                    <div>

                    </div>

                    <div class="input-group no-border">
                        <input type="text" id="search" onkeyup="preClick(3);" class="form-control" placeholder="Search...">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <i class="now-ui-icons ui-1_zoom-bold"></i>
                            </div>
                        </div>
                    </div>
                    <!-- <input type="text" id="search" onkeyup="preClick(3);" placeholder="Search.."> -->

                </div>
                <div class="card-body">
                    <div style="overflow:auto;height: 400px;">
                        <table id="data" class="table">
                            <tbody id="databody">
                                <tr id="jstable1">
                                    <th rowspan="2">ID</th>
                                    <th rowspan="2">Employee</th>

                                </tr>
                                <tr id="jstable">

                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script>
        $(document).ready(function() {
            preClick(2);
        });

      
        //const myFather = new Person("John", "Doe", 50, "blue");
        ////people.push(myFather);

       

        var currentMonth = new Date().getMonth();
        var currentYear = new Date().getFullYear();
        var dayNames = ["Sun", "Mon", "Tue", "Wed", "Thur", "Fri", "Sat"];
        var tableMonth = currentMonth + 1
        var days = daysInMonth(tableMonth);
        var idnum = 0;

        function preClick(kt) {
            if (kt == 0) {
                tableMonth = tableMonth - 1;
            } else {
                if (kt == 1) {
                    tableMonth = tableMonth + 1;
                }

            }

            $('#jstable').children('#listening').remove();
            $('#jstable1').children('#listening').remove();
            $('#databody').children('#abc').remove();

            days = daysInMonth(tableMonth);
            displaySheet();
            search();
        }

        function daysInMonth(month) {

            return new Date(currentYear, month, 0).getDate();
        }
        displaySheet();

        function displaySheet() {
            var total = 0;
            document.getElementById("month_now").innerHTML = "REPORT  :   " + tableMonth + " / " + currentYear;
            for (var i = 1; i <= days; i++) {
                var day = new Date(currentYear, tableMonth - 1, i).getDay();
                if (dayNames[day] != 'Sat' && dayNames[day] != 'Sun') {
                    total++;
                }
                var string1 = " <th id='listening'>" + dayNames[day] + "</th>";
                //console.log(string1);
                var string = "  <th id='listening'> " + i + "</th>";

                $("#jstable1").append(string1);
                $("#jstable").append(string);

            }
            var string3 = "  <th id='listening'>" + total + "</th>";
            $("#jstable").append(string3);
            var string2 = "  <th id='listening'>Total</th>";
            $("#jstable1").append(string2);
        }

        function detail(id) {
            //alert(id);
            get_detail(id);
        }

        function search() {
            var txt = document.getElementById("search").value;
            $('#result').html('');
            $.ajax({
                url: "/report_ajax",
                // method: "GET",
                type: "GET",
                data: {
                    search: txt,
                    m: tableMonth,
                    d: days,

                },
                dataType: "json",
                success: function(data) {
                    //$('#result').html(data.msg);
                    // console.log(data.msg);
                    $("#data").append(data.msg);
                    // document.getElementById('#result').innerHTML = data;
                    // $('#result').innerHTML = data
                }
            });
        }

        function get_detail(detail_id) {
            $('#detail').html('');
            $.ajax({
                url: "/report_ajax",
                // method: "GET",
                type: "GET",
                data: {
                    id: detail_id,

                },
                dataType: "json",
                success: function(data) {
                    $('#detail').html(data.msg);
                }
            });
        }
    </script>
    @endsection