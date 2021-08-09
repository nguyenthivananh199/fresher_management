@extends('fresher.layout.master')
@section("content")
<style>
    div.a {

        border-radius: 5px;
        white-space: nowrap;
        width: 154px;
        overflow: hidden;
        text-overflow: ellipsis;
        font-size: 10pt;
        background-color: white;
        margin-left: 10px;
        border: 1px solid #000000;

    }

    div.a:hover {
        text-align: center;
        width: 200px;
        border-radius: 5px;
        overflow: visible;
        border: 1px solid #000000;
        background-color: greenyellow;
        color: red;
    }
</style>
<link href="/demo/fresher.css" rel="stylesheet" />

<!-- Contact section -->
<section id="about">
    <div class="container">
        <div class="row">

            <div class="col-md-10 " data-wow-delay="0.2s" style="width:99%;">
                <h1>TIMESHEET</h1>
                <p>Quisque tempor bibendum dolor at volutpat. Suspendisse venenatis quam sed libero euismod feugiat. In cursus nisi vitae lectus facilisis mollis. Nullam scelerisque, quam nec iaculis vulputate.</p>
                <div class="about-thumb">



                    <div class="modal fade" id="myModal" role="dialog">
                        <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div style="text-align: center;margin-top:4%;" class="">
                                    <h4>Timesheet detail</h4>
                                    <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
                                </div>
                                <div class="modal-body" id="detail">

                                </div>

                            </div>

                        </div>
                    </div>
                    <!-- ------------- -->




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







            <!-- end team carousel -->

        </div>
    </div>


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
                url: "/timesheet_fresher",
                // method: "GET",
                type: "GET",
                data: {
                    m: currentMonth + 1,
                    d: daysInMonth(currentMonth + 1),

                },
                dataType: "json",
                success: function(data) {
                    //$('#result').html(data.msg);
                    //console.log(data.msg);
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
                console.log(arr);
                var tmp = arr[i];
                if (tmp != -1) {
                    const myArr = tmp.split("/");
                    console.log("...............");

                    if (myArr[0] == 'Full') {
                        $(x).addClass("report_in_time");
                    } else {
                        for (var j = 0; j < myArr.length - 1; j++) {

                            console.log(myArr[j]);
                            an1_text = '<div class="a"style="margin:0px;"> ' + myArr[j] + '</a>'
                            $(x).append(an1_text);

                        }
                        console.log(myArr[myArr.length - 1]);
                        if (myArr[myArr.length - 1] == 'N') {
                            $(x).addClass("report_missing");
                        }
                        if (myArr[myArr.length - 1] == 'Y') {
                            $(x).addClass("report_out_time");
                        }
                    }

                    //}
                } else {
                    var m = currentMonth + 1;
                    var tmp1 = currentYear + '-' + m + '-' + i;

                    var d = new Date(tmp1);

                    if (d.getDay() == '0' || d.getDay() == '6') {
                        console.log("hello");
                    } else {
                        if (currentMonth <= currentMonth1) {
                            an1_text = '<div class="a"style="margin:0px;">Day off: no permission</a>'
                            $(x).append(an1_text);
                            $(x).addClass("report_missing");
                        }
                    }

                }


                // if (myArr.length == 0) {
                //     an1_text = '<div class="a"style="margin:0px;">Day off: no permission</a>'
                //         $(x).append(an1_text);
                // } else {
                //     for (var j = 0; j < myArr.length - 1; j++) {

                //         console.log(myArr[j]);
                //         an1_text = '<div class="a"style="margin:0px;"> ' + myArr[j] + '</a>'
                //         $(x).append(an1_text);
                //     }
                // }

                // if (arr[i] == '+') {
                //     $(x).addClass("report_in_time");
                // } else {
                //     if (arr[i] == '-') {
                //         $(x).addClass("report_out_time");

                //     } else {
                //         if (currentMonth <= currentMonth1) {
                //             $(x).addClass("report_missing");

                //             an1_text='<p>Absence no permission</p>'
                //             $(x).append(an1_text);

                //         }

                //     }
                // }

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
                var string = "<div class='month'><div id='" + i + "'class='month-selector  center-vh clickable' onclick='detail_report(" + i + ")' data-toggle='modal' data-target='#myModal' ><p style='padding:7%;'>" + i + "</p></div></div>";
                $("#calender-content").append(string);
            }

        }

        function detail_report(detail_day) {

            $('#detail').html('');
            $.ajax({
                url: "/timesheet_fresher",
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
            // var check_today_report='';

            // if(check_today_report=="true"){
            //     //disable add 

            //     document.getElementById("addBtn").disabled = true;
            // }else{
            //     //disable update
            //     document.getElementById("editBtn").disabled = true;
            // }

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

</section>
@endsection