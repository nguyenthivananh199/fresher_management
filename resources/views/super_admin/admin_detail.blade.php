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
<div id="snackbar"> @if($errors->any())
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>

    @endforeach
    @endif
</div>
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">

            <div class="modal-body" id="detail">
                <div class="card">
                    <div class="card-header">
                        <h5 class="title">Update avarar</h5>
                    </div>
                    <div class="card-body">
                        <form action="update_ava" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-md-12">
                                    <div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div>
                                                    <label for="exampleInputEmail1">Picture</label>
                                                    <input class="form-control" type="file" name="pic" id="pic" required>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="id" id="" value="{{$user['id']}}">
                                        <input type="hidden" name="pre_img" id="" value="{{$user['img']}}">
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="submit-btn  btn-info btn" name="submit"> Submit</button>
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
                <div class="card-header"></div>

                <div class="card-body">



                    <!-- onkeydown="return /[a-z, ]/i.test(event.key)" onblur="if (this.value == '') {this.value = '';}" onfocus="if (this.value == '') {this.value = '';}" -->
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">


                                    <h5 class="title">Admin Detail</h5>

                                </div>
                                <div class="card-body">

                                    <form method="POST" action="update_admin">
                                        @csrf
                                        <input type="hidden" name="id" id="" value="{{$user['id']}}">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Fullname</label>
                                                    <input type="text" class="form-control" onkeyup="setEmail();" name="name" id="name" placeholder="name" value="{{$user['name']}}">
                                                </div>
                                            </div>
                                        </div>


                                        <!-- onkeydown="return /[a-z, ]/i.test(event.key)" onblur="if (this.value == '') {this.value = '';}" onfocus="if (this.value == '') {this.value = '';}" -->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Email address</label>
                                                    <input type="email" onkeyup="mai_check_existed()" class="form-control" name="email" id="email" placeholder="Email" value="{{$user['email']}}">
                                                    <p id="check"></p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Date of birth</label>
                                                    <input type="date" class="form-control" id="dob" name="dob" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 pr-1">
                                                <div class="form-group">
                                                    <label>Part</label>
                                                    <input type="text" class="form-control" placeholder="Part" name="part" value="{{$user['part']}}" required>
                                                </div>
                                            </div>

                                            <div class="col-md-6 pl-1">
                                                <div class="form-group">
                                                    <label>Phone</label>
                                                    <input type="number" class="form-control" placeholder="Phone" name="phone" value="{{$user['phone']}}" required>
                                                </div>
                                            </div>
                                        </div>



                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Role</label>
                                                    <div id="checkboxes">
                                                        <select name="role" id="role" class="form-control">
                                                            @foreach ($role_list as $part)

                                                            <option value="{{$part->name}}">{{$part->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Extra permission</label>
                                                    <div id="checkboxes">
                                                        <input type="checkbox" id="Fresher_management" name="Fresher_management" value="Fresher management">
                                                        <label for="vehicle1">Fresher management</label><br>

                                                        <input type="checkbox" id="Timesheet_management" name="Timesheet_management" value="Timesheet management">
                                                        <label for="vehicle1">Timesheet management</label><br>

                                                        <input type="checkbox" id="Report_management" name="Report_management" value="Report management">
                                                        <label for="vehicle1">Report management</label><br>


                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <button type="submit" name="submit" value="submit" id="submit" class="submit-btn btn btn-info"> submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card card-user">
                                <div class="image">

                                </div>
                                <div class="card-body">
                                    <div class="author">
                                        <a href="#">
                                            <img class="avatar border-gray" data-toggle="modal" data-target="#myModal" src="{{$user['img']}}" alt="...">
                                            <p>Change avatar</p>
                                        </a>
                                        <h5 class="title">{{$user['name']}}</h5>
                                    </div>

                                </div>
                                <hr>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
     function set_nav() {
            $(".nav1 li").removeClass("active");
            $('#admin_nav').addClass('active');
        }
        $(document).ready(function() {
            set_nav();
            var tmp = "<?php echo  $user->dob; ?>";
            document.getElementById("dob").value = tmp;


            <?php if ($errors->any()) { ?>
                var x = document.getElementById("snackbar");
                x.className = "show";
                setTimeout(function() {
                    x.className = x.className.replace("show", "");
                }, 3000);

            <?php } ?>


            document.getElementById("role").value = "<?php echo $role[0]; ?>";
            const permision_list = [];
            <?php for ($i = 0; $i < count($permission); $i++) { ?>
                var tmp = '<?php echo $permission[$i]; ?>';
                tmp = tmp.replace(/ /g, "_");
                document.getElementById(tmp).checked = true;
            <?php } ?>


        });

        function mai_check_existed() {
            var prev_mail = "<?php echo  $user->email; ?>";
            var txt = document.getElementById("email").value;
            console.log("value :" + txt);
            $.ajax({
                url: "/email_ajax",
                // method: "GET",
                type: "GET",
                data: {
                    search: txt,
                    prev_mail: prev_mail,
                },
                dataType: "json",
                success: function(data) {
                    // $('#result').html(data.msg);
                    console.log(data.msg);

                    if (data.msg == 0) {
                        document.getElementById("check").innerHTML = "Email available !";
                        document.getElementById("submit").disabled = false;
                    } else {
                        document.getElementById("check").innerHTML = "Email unavailable !";
                        document.getElementById("submit").disabled = true;
                    }
                    // $("#data").append(data.msg);
                    // document.getElementById('#result').innerHTML = data;
                    // $('#result').innerHTML = data
                }
            });
        }
    </script>
    @endsection