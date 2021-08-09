@extends('master')
@section("content")
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
                    <div class="input-group no-border">
                        <input type="text" id="search" onkeyup="preClick(3);" class="form-control"
                            placeholder="Search...">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <i class="now-ui-icons ui-1_zoom-bold"></i>
                            </div>
                        </div>
                    </div>
                    <div class="input-group no-border">


                        <div class="drop" onclick="myFunctiondrop()" style="float:right;">
                            <button class="dropbtn" style="border: none;">Filter</button>

                        </div>
                    </div>
                    <div class="row" id="demodrop" style="display: none;padding-bottom: 2%;">

                        <div class="col-4">
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
                        <div class="col-4">
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
                                        <th>Id Fresher</th>
                                        <th>Name</th>
                                        <th>Absence date</th>
                                        <th>Type</th>
                                        <th>Created at</th>
                                        <th>Status</th>
                                        
                                        
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
        var tableMonth = currentMonth + 1;
        var status_value='';
        var status_id=-1;
        var idnum = 0;

        var selected_ = [];
        function set_status_id(id){
            status_id=id;
          
            test();
            preClick(3);
        }

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
        function test(){
            
            var status_selector=document.getElementById(status_id);
            if(typeof(status_selector) != 'undefined' && status_selector != null){
                status_value=document.getElementById(status_id).value;
                
            }else{
                status_value='';
            }
        }
        function searchFresher(delete_id) {
            //filter_class
            
            
            var search_txt=document.getElementById("search").value;
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
                url: "/view_request_admin",
                // method: "GET",
                type: "GET",
                data: {
                    status_id:status_id,
                    status_value:status_value,
                    search_txt:search_txt,
                    search: txt,
                    deleteid: deleteid,
                    req_type: req_type,
                    req_order: req_order,

                },
                dataType: "json",
                success: function(data) {
                    // $('#result').html(data.msg);
                     // console.log(data.msg);
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
    @endsection