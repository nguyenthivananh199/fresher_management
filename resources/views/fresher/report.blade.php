@extends('fresher.layout.master')
@section("content")



<link href="/demo/fresher.css" rel="stylesheet" />

<!-- Contact section -->
<section id="about">
    <div class="container">
        <div class="row">

            <div class="col-md-10 " data-wow-delay="0.2s" style="width:99%;">
                <h1>REPORT</h1>
                <p>Quisque tempor bibendum dolor at volutpat. Suspendisse venenatis quam sed libero euismod feugiat. In cursus nisi vitae lectus facilisis mollis. Nullam scelerisque, quam nec iaculis vulputate.</p>
                <div class="about-thumb">



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
                    <!-- ADDING REPORT MODAL BOX -->



                    <div class="modal fade" id="add_report" role="dialog">
                        <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div style="text-align: center;margin-top:4%;" class="">

                                    <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
                                </div>
                                <div class="modal-body" id="">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="title">Add Daily Report</h5>
                                        </div>
                                        <div class="card-body">
                                            <form action="add_report" method="POST">
                                                @csrf

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">Today plan</label>
                                                            <textarea rows="2" class="form-control" name="today_plan" style="width: 100%;"></textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">Actual</label>
                                                            <textarea rows="2" class="form-control" name="actual" style="width: 100%;"></textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">Tomorrow plan</label>
                                                            <textarea rows="2" class="form-control" name="tomorrow_plan" style="width: 100%;"></textarea>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">Issues</label>
                                                            <textarea rows="2" class="form-control" name="issues" style="width: 100%;"></textarea>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">Action</label>
                                                            <textarea rows="2" class="form-control" name="action" style="width: 100%;"></textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">Note</label>
                                                            <textarea rows="2" class="form-control" name="note" style="width: 100%;"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- onkeydown="return /[a-z, ]/i.test(event.key)" onblur="if (this.value == '') {this.value = '';}" onfocus="if (this.value == '') {this.value = '';}" -->

                                        </div>
                                        <button type="submit" name="submit"> Submit</button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>


                    <!-- -------------------- -->

                    <!-- UPDATING REPORT MODAL BOX -->



                    <div class="modal fade" id="update_report" role="dialog">
                        <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div style="text-align: center;margin-top:4%;" class="">

                                    <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
                                </div>
                                <div class="modal-body" id="">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="title">Edit Daily Report</h5>
                                        </div>
                                        <div class="card-body">
                                            <form action="edit_report" method="POST">
                                                @csrf
                                                <input type="hidden" name="id" id="" value="{{$daily_report['id']}}">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">Today plan</label>
                                                            <textarea rows="2" class="form-control" name="today_plan" style="width: 100%;">{{$daily_report['today_plan']}}</textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">Actual</label>
                                                            <textarea rows="2" class="form-control" name="actual" style="width: 100%;">{{$daily_report['actual']}}</textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">Tomorrow plan</label>
                                                            <textarea rows="2" class="form-control" name="tomorrow_plan" style="width: 100%;">{{$daily_report['tomorrow_plan']}}</textarea>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">Issues</label>
                                                            <textarea rows="2" class="form-control" name="issues" style="width: 100%;">{{$daily_report['issues']}}</textarea>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">Action</label>
                                                            <textarea rows="2" class="form-control" name="action" style="width: 100%;">{{$daily_report['action']}}</textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">Note</label>
                                                            <textarea rows="2" class="form-control" name="note" style="width: 100%;">{{$daily_report['note']}}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- onkeydown="return /[a-z, ]/i.test(event.key)" onblur="if (this.value == '') {this.value = '';}" onfocus="if (this.value == '') {this.value = '';}" -->

                                        </div>
                                        <button type="submit" name="submit"> Submit</button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>

                <!-- -------------------- -->

                <button data-toggle="modal" id="addBtn" data-target="#add_report">Add Today Report</button>
                <button data-toggle="modal" id="editBtn" data-target="#update_report">Edit Today Report</button>
                <div id="calender-title" class="disable-select flex row center-v around">
                    <div id="left" class="flex row center-vh"><span>
                            < </span>
                    </div>
                    <p class="flex row center-vh"></p>
                    <div id="right" class="flex row center-vh"><span>></span></div>
                </div>
                <div id="calender-wrapper">


                    <div id="days" class="flex row center-vh colorRed disable-select">
                        <p>MON</p>
                        <p>TUE</p>
                        <p>WEDS</p>
                        <p>THURS</p>
                        <p>FRI</p>
                        <p>SAT</p>
                        <p>SUN</p>
                    </div>
                    <div id="calender-content" class="flex row wrap disable-select">
                    </div>

                </div>




            </div>
        </div>


    </div>




    <!-- end team carousel -->

    </div>
    </div>


    </body>
    <script>
        var currentMonth = new Date().getMonth();
        var currentMonth1 = new Date().getMonth();
        var currentYear = new Date().getFullYear();
        var clickedDays = 0;
        var bookingSteps = 0;
        var lastClickedDay;
        var startDate = "";
        var endDate = "";
        var monthNames = ["January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
        ];
        var monthShortNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        var dayNames = ["Sun", "Mon", "Tue", "Wed", "Thur", "Fri", "Sat"];


        Date.prototype.addDays = function(days) {
            var dat = new Date(this.valueOf())
            dat.setDate(dat.getDate() + days);
            return dat;
        }

        function search() {
            $.ajax({
                url: "/report_fresher",
                // method: "GET",
                type: "GET",
                data: {
                    m: currentMonth + 1,
                    d: daysInMonth(currentMonth + 1),

                },
                dataType: "json",
                success: function(data) {
                    //$('#result').html(data.msg);
                    console.log(data.msg);
                    add_class(data.msg);
                    // $("#data").append(data.msg);
                    // document.getElementById('#result').innerHTML = data;
                    // $('#result').innerHTML = data
                }
            });
        }

        function add_class(arr) {
            for (var i = 1; i < arr.length; i++) {
                var x = "#" + i;

                if (arr[i] == '+') {
                    $(x).addClass("report_in_time");
                } else {
                    if (arr[i] == '-') {
                        $(x).addClass("report_out_time");
                    } else {
                        var m = currentMonth + 1;
                        var tmp = currentYear + '-' + m + '-' + i;
                        var d = new Date(tmp);
                        console.log("...........");
                        console.log(i);
                        console.log(d.getDay());
                        if (d.getDay() == '0' || d.getDay() == '6') {
                            console.log("hello");
                        } else {
                            if (currentMonth <= currentMonth1) {
                                $(x).addClass("report_missing");
                            }
                        }



                    }
                }

            }
        }

        function daysInMonth(month) {
            return new Date(currentYear, month, 0).getDate();
        }

        function displayCalender() {
            var days = daysInMonth(currentMonth + 1);

            $("#calender-title p").html(monthNames[currentMonth].toUpperCase());
            $("#calender-content").html("");
            if (firstDayOffset(new Date()) == 0) {
                for (var i = 1; i <= 6; i++) {
                    $("#calender-content").append("<div class='month flex center-vh'></div>");
                }
            } else {
                for (var i = 1; i < firstDayOffset(new Date()); i++) {
                    $("#calender-content").append("<div class='month flex center-vh'></div>");
                }
            }

            for (var i = 1; i <= days; i++) {
                var day = new Date(currentYear, currentMonth, i).getDay();
                var string = "<div class='month'><div id='" + i + "'class='month-selector flex center-vh clickable' onclick='detail_report(" + i + ")' data-toggle='modal' data-target='#myModal' ><p>" + i + "</p></div></div>";
                $("#calender-content").append(string);
            }

        }

        function detail_report(detail_day) {

            $('#detail').html('');
            $.ajax({
                url: "/report_fresher",
                // method: "GET",
                type: "GET",
                data: {
                    detail_day: detail_day,
                    month: currentMonth + 1,

                },
                dataType: "json",
                success: function(data) {
                    $('#detail').html(data.msg);
                    // console.log(data.msg);
                }
            });
        }

        function firstDayOffset(date) {

            return new Date(currentYear, currentMonth, 1).getDay();
        }





        $(function() {
            var check_today_report = '<?php echo $check_report; ?>';
            var m = currentMonth + 1;
            var today = new Date();
            var i=today.getDate();
            var tmp1 = currentYear + '-' + m + '-' + i;
console.log(tmp1);
            var d = new Date(tmp1);
            if (d.getDay() == '0' || d.getDay() == '6') {
                document.getElementById("addBtn").disabled = true;
                document.getElementById("editBtn").disabled = true;
                
            } else {
                if (check_today_report == "true") {
                    //disable add 

                    document.getElementById("addBtn").disabled = true;
                } else {
                    //disable update
                    document.getElementById("editBtn").disabled = true;
                }
            }


            displayCalender(currentMonth)
            $("#date").append(new Date);
            search();
        });

        $("#left").on("click", function() {
            if (currentMonth > 0)
                currentMonth -= 1;
            else {
                currentMonth = 11;
                currentYear -= 1;
            }
            displayCalender();
            search();
        });
        $("#right").on("click", function() {
            if (currentMonth < 11)
                currentMonth += 1;
            else {
                currentMonth = 0;
                currentYear += 1;
            }
            displayCalender();
            search();
        });
    </script>
    @endsection