<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link href="/demo/fresher.css" rel="stylesheet" />


    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <!-- CSS Files -->
    <link href="/css/bootstrap.min.css" rel="stylesheet" />
    <link href="/css/now-ui-dashboard.css?v=1.5.0" rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="/demo/demo.css" rel="stylesheet" />

    <title>Document</title>
</head>

<body>
    <!-- ADDING REPORT MODAL BOX -->



    <div class="modal fade" id="add_request" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div style="text-align: center;margin-top:4%;" class="">

                    <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
                </div>
                <div class="modal-body" id="">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="title">Add Request</h5>
                        </div>
                        <div class="card-body">
                            <form action="add_request" method="POST">
                                @csrf

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Reason</label>
                                            <textarea rows="2" class="form-control" name="reason"
                                                style="width: 100%;"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Absence date</label>
                                            <input type="date" name="date" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Absence </label>
                                            <select name="type" id="cars" class="form-control">
                                                <option value="Morning">Morning</option>
                                                <option value="Afternoon">Afternoon</option>
                                                <option value="Leave early">Leave early</option>
                                                <option value="Morning late">Morning late</option>
                                                <option value="Full">Full</option>

                                            </select>
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

    <button data-toggle="modal" id="reqBtn" data-target="#add_request">Make Request</button>

    <div class="panel-header panel-header-sm">
    </div>
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">

                        <div class="row">



                        </div>
                        <div>

                        </div>

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

                        <div class="input-group no-border">


                            <div class="drop" onclick="myFunctiondrop()" style="float:right;">
                                <button class="dropbtn" style="border: none;">Filter</button>

                            </div>
                        </div>
                        <div class="row" id="demodrop" style="display: none;padding-bottom: 2%;">

                            <div class="col-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Absence </label>
                                    <select name="type" id="type" onclick="preClick(3)" class="form-control">
                                        <option value="">All</option>
                                        <option value="Morning">Morning</option>
                                        <option value="Afternoon">Afternoon</option>
                                        <option value="Full">Full</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Absence </label>
                                    <select name="order" id="order" onclick="preClick(3)" class="form-control">
                                        <option value="desc">New to old</option>
                                        <option value="asc">Old to new</option>
                                    </select>
                                </div>
                            </div>

                            <!-- <input type="submit" value="Submit now" /> -->
                            <!-- </fieldset> -->
                        </div>
                        <!-- <input type="text" id="search" onkeyup="preClick(3);" placeholder="Search.."> -->

                    </div>
                    <div class="card-body">
                        <div style="overflow:auto;height: 400px;">
                            <table id="data" class="table">
                                <tbody id="databody">
                                    <tr id="jstable1">

                                        <th>ID</th>
                                        <th>Absence date</th>
                                        <th>Type</th>
                                        <th>Created at</th>
                                        <th>Status</th>
                                        <th>Function</th>
                                    </tr>


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <script>
        var currentMonth = new Date().getMonth();
        var currentYear = new Date().getFullYear();
        var tableMonth = currentMonth + 1

        var idnum = 0;

        var selected_ = [];


        function preClick(kt) {
            if (kt == 0) {
                tableMonth = tableMonth - 1;
            } else {
                if (kt == 1) {
                    tableMonth = tableMonth + 1;
                }

            }
            if (tableMonth > 12 || tableMonth < 1) {
                tableMonth = new Date().getMonth() + 1;
            }


            document.getElementById("month_now").innerHTML = tableMonth + " / " + currentYear;
            $('#databody').children('#abc').remove();

            searchFresher();
        }


        function deleteFresher(id_fresher) {
            var txt;
            if (confirm("Are you sure to delete ?")) {
                //yes

                searchFresher(id_fresher);
            } else {}
        }



        $(document).ready(function() {
            preClick(3);
        });
        //ajax

        function searchFresher(delete_id) {
            //filter_class
            var req_type = document.getElementById("type").value;
            var req_order = document.getElementById("order").value;
            //alert(selected_);
            //delete by id
            var deleteid = -1;
            if (typeof delete_id == 'undefined') {
                // the variable is defined

            } else {
                deleteid = delete_id;
            }
            $('#databody').children('#abc').remove();
            var txt = tableMonth;
            $('#result').html('');
            $.ajax({
                url: "/view_request",
                // method: "GET",
                type: "GET",
                data: {
                    search: txt,
                    deleteid: deleteid,
                    req_type: req_type,
                    req_order: req_order,

                },
                dataType: "json",
                success: function(data) {
                    // $('#result').html(data.msg);
                    //  console.log(data.msg);
                    $("#data").append(data.msg);
                    // document.getElementById('#result').innerHTML = data;
                    // $('#result').innerHTML = data
                }
            });
        }
        //filter dropdown list
        function myFunctiondrop() {
            if (document.getElementById("demodrop").style.display == "none") {
                document.getElementById("demodrop").style.display = "flex";
            } else {
                document.getElementById("demodrop").style.display = "none";
            }
        }
        </script>
</body>

</html>