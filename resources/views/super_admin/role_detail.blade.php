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

<!-- ------------- -->
<div id="snackbar">
@foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>

                        @endforeach
</div>

<div class="panel-header panel-header-sm">
</div>
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"></div>

                <div class="card-body">



                    <!-- onkeydown="return /[a-z, ]/i.test(event.key)" onblur="if (this.value == '') {this.value = '';}" onfocus="if (this.value == '') {this.value = '';}" -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">


                                    <h5 class="title">Role Detail</h5>
                                </div>
                                <div class="card-body">

                                    <form method="POST" action="update_role">
                                        @csrf
                                        <div id="check"></div>
                                        <input type="hidden" name="id" id="" value="{{$role['id']}}">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Fullname</label>
                                                    <input type="text" class="form-control" onkeyup="check_exist_role();" name="name" id="name" placeholder="name" value="{{$role['name']}}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Permission</label>
                                                    <div id="checkboxes">

                                                        <input type="checkbox" id="Fresher_management" name="Fresher_management" value="Fresher management" class="acb" onclick='deRequireCb("acb")' required >
                                                        <label for="vehicle1">Fresher management</label><br>

                                                        <input type="checkbox" id="Timesheet_management" name="Timesheet_management" value="Timesheet management" class="acb" onclick='deRequireCb("acb")' required>
                                                        <label for="vehicle1">Timesheet management</label><br>

                                                        <input type="checkbox" id="Report_management" name="Report_management" value="Report management" class="acb" onclick='deRequireCb("acb")' required>
                                                        <label for="vehicle1">Report management</label><br>


                                                    </div>

                                                    <button type="submit" name="submit" id="submit" class="submit-btn  btn-info btn" value="submit"> submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>

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
            // alert(atLeastOneChecked);
         }
         function set_nav() {
            $(".nav1 li").removeClass("active");
            $('#role_nav').addClass('active');
        }
        $(document).ready(function() {
            set_nav();
            const permision_list = [];
          
            <?php if ($errors->any()) { ?>
                var x = document.getElementById("snackbar");
                x.className = "show";
                setTimeout(function() {
                    x.className = x.className.replace("show", "");
                }, 3000);

            <?php } ?>
            <?php for ($i = 0; $i < count($permission); $i++) { ?>
                var tmp = '<?php echo $permission[$i]['name']; ?>';
                tmp = tmp.replace(/ /g, "_");
                document.getElementById(tmp).checked = true;
            <?php } ?>
            deRequireCb('acb');
        });

        function check_exist_role() {
            var isUpdate = '<?php echo $role['name']; ?>';
            var name = document.getElementById('name').value;
            $('#check').html('');

            $.ajax({
                url: "/check_exist_role",
                // method: "GET",
                type: "GET",
                data: {
                    name: name,
                    isUpdate: isUpdate,
                },
                dataType: "json",
                success: function(data) {
                    $('#check').html(data.msg);
                    console.log(data.msg);
                    if (data.msg != '') {
                        document.getElementById('submit').disabled = true;
                    } else {
                        document.getElementById('submit').disabled = false;
                    }
                    // $("#data").append(data.msg);
                    // document.getElementById('#result').innerHTML = data;
                    // $('#check').innerHTM = data;
                }
            });
        }
    </script>
    @endsection