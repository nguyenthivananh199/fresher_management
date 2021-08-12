@extends('master')
@section("content")
<!-- modal box -->
<style>
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    #snackbar {
        visibility: hidden;
        min-width: 250px;
        margin-left: -125px;
        background-color: #333;
        color: #fff;
        text-align: center;
        border-radius: 2px;
        padding: 16px;
        position: fixed;
        z-index: 1;
        left: 60%;
        bottom: 30px;
        font-size: 17px;
    }

    #snackbar.show {
        visibility: visible;
        opacity: 0.7;
    }
</style>
<div id="snackbar">
@foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>

                        @endforeach
</div>
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">

            <div class="modal-body" id="detail">
                <div class="card">
                    <div class="card-header">
                        <h5 class="title">Add Role</h5>
                    </div>
                    <div class="card-body">
                        <form action="add_role" method="POST">
                            @csrf
                            <div id="check"></div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Role name</label>
                                        <input type="text" class="form-control" onkeyup="check_exist_role()"  name="name" id="name" placeholder="name">
                                    </div>
                                </div>
                            </div>


                            <!-- onkeydown="return /[a-z, ]/i.test(event.key)" onblur="if (this.value == '') {this.value = '';}" onfocus="if (this.value == '') {this.value = '';}" -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                    <label for="exampleInputEmail1">Permission</label>
                                    <div id="checkboxes ">
                                @foreach ($permission as $part)
                                <input type="checkbox"  id="class" name="{{$part->name}}" value="{{$part->name}}" class="acb" onclick='deRequireCb("acb")' required>
                                <label for="vehicle1">{{$part->name}} </label><br>
                                

                                @endforeach
                            </div>
                                    </div>
                                </div>
                            </div>

                            
                            
                            <button type="submit" name="submit" id="submit" class="submit-btn  btn-info btn"> Submit</button>
                        </form>
                    </div>
                </div>
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
                    <div class="col-10"></div>

                        <button class="col btn btn-info " data-toggle="modal" data-target="#myModal">Add Role</button>
                    </div>
                    <div style="text-align: center;">
                    <h3>ROLE MANAGEMENT</h3>
                    </div>
                    <div>

                    </div>

                    <div class="input-group no-border">
                        <input type="text" id="search" onkeyup="searchFresher();" class="form-control" placeholder="Search...">
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

                                    <th>ID</th>
                                    <th>Name</th>
                                    
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
        function deRequireCb(elClass) {
           
          //  document.getElementsByClassName("acb").required = false;
            el=document.getElementsByClassName(elClass);
            
            var atLeastOneChecked=false;//at least one cb is checked
            for (i=0; i<el.length; i++) {
                if (el[i].checked === true) {
                    atLeastOneChecked=true;
                }
            }

            if (atLeastOneChecked === true) {
                for (i=0; i<el.length; i++) {
                    $(".acb").removeAttr("required");
                }
            } else {
                for (i=0; i<el.length; i++) {
                    $(".acb").attr("required","");
                }
            }
        }
        function check_required_permission(){
            if($('div..required :checkbox:checked').length > 0){
                   document.getElementById('submit').disabled=false;
                   alert('ok');
            }else{
                document.getElementById('submit').disabled=true;
                alert("no");
            }
        }
        function check_exist_role(){
            var name=document.getElementById('name').value;
            $('#check').html('');
           
            $.ajax({
                url: "/check_exist_role",
                // method: "GET",
                type: "GET",
                data: {
                    name:name,
                },
                dataType: "json",
                success: function(data) {
                     $('#check').html(data.msg);
                     console.log(data.msg);
                     if(data.msg!=''){
                         document.getElementById('submit').disabled=true;
                     }else{
                        document.getElementById('submit').disabled=false;
                     }
                   // $("#data").append(data.msg);
                    // document.getElementById('#result').innerHTML = data;
                    // $('#check').innerHTM = data;
                }
            });
        }

        var selected_ = [];

        // function class_filter() {
        //     var selected = [];
        //     $('#checkboxes input:checked').each(function() {
        //         selected.push($(this).attr('name'));
        //     });
        //     selected_ = selected;
        //     searchFresher();
        // }

        function deleteFresher(id_fresher) {
            var txt;
            if (confirm("Are you sure to delete ?")) {
                //yes

                searchFresher(id_fresher);
            } else {}
        }
        function set_nav() {
            $(".nav1 li").removeClass("active");
            $('#role_nav').addClass('active');
        }
        $(document).ready(function() {
            set_nav();
            <?php if ($errors->any()) { ?>
                var x = document.getElementById("snackbar");
                x.className = "show";
                setTimeout(function() {
                    x.className = x.className.replace("show", "");
                }, 3000);

            <?php } ?>
            searchFresher();
        });
       
        
        //ajax

        function searchFresher(delete_id) {
            //filter_class
            // for (var i = 0; i < 3; i++) {
            //     if (typeof selected_[i] == 'undefined') {
            //         // the variable is defined
            //         selected_[i] = '';

            //     }
            // }
            //alert(selected_);
            //delete by id
            var deleteid = -1;
            if (typeof delete_id == 'undefined') {
                // the variable is defined

            } else {
                deleteid = delete_id;
            }
            $('#databody').children('#abc').remove();
            var txt = document.getElementById("search").value;
            $('#result').html('');
            $.ajax({
                url: "/display_admin_list",
                // method: "GET",
                type: "GET",
                data: {
                    search: txt,
                    deleteid: deleteid,
                    // class1: selected_[0],
                    // class2: selected_[1],
                    // class3: selected_[2],
                },
                dataType: "json",
                success: function(data) {
                    // $('#result').html(data.msg);
                     console.log(data.msg);
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