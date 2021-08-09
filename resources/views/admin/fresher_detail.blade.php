@extends('master')
@section("content")

<!-- modal box -->
<style>
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
</style>
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
                                    <div >
                                       
                                        <input type="file" name="pic" id="pic" >
                                        <input type="hidden" name="id" id="" value="{{$user['id']}}">
                                        <input type="hidden" name="pre_img" id="" value="{{$user['img']}}">
                                    </div>
                                </div>
                            </div>



                            <button type="submit" name="submit"> Submit</button>
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


                                    <h5 class="title">Fresher Detail</h5>

                                </div>
                                <div class="card-body">

                                    <form method="POST" action="update">
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
                                            <div class="col-md-4 pr-1">
                                                <div class="form-group">
                                                    <label>Part</label>
                                                    <input type="text" class="form-control" placeholder="Part" name="part" value="{{$user['part']}}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4 px-1">
                                                <div class="form-group">
                                                    <label>Class</label>
                                                    <input type="text" class="form-control" placeholder="Class" name="class" value="{{$user['class']}}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4 pl-1">
                                                <div class="form-group">
                                                    <label>Phone</label>
                                                    <input type="number" class="form-control" placeholder="Phone" name="phone" value="{{$user['phone']}}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" name="submit" value="submit"> submit</button>
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
                                            <h5 class="title">Mike Andrew</h5>
                                        </a>
                                        <p class="description">
                                            michael24
                                        </p>
                                    </div>
                                    <p class="description text-center">
                                        "Lamborghini Mercy <br>
                                        Your chick she so thirsty <br>
                                        I'm in that two seat Lambo"
                                    </p>
                                </div>
                                <hr>
                                <div class="button-container">
                                    <button href="#" class="btn btn-neutral btn-icon btn-round btn-lg">
                                        <i class="fab fa-facebook-f"></i>
                                    </button>
                                    <button href="#" class="btn btn-neutral btn-icon btn-round btn-lg">
                                        <i class="fab fa-twitter"></i>
                                    </button>
                                    <button href="#" class="btn btn-neutral btn-icon btn-round btn-lg">
                                        <i class="fab fa-google-plus-g"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            var tmp = "<?php echo  $user->dob; ?>";
            document.getElementById("dob").value = tmp;
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
                        document.getElementById("check").innerHTML = "Email available !"
                    } else {
                        document.getElementById("check").innerHTML = "Email unavailable !"
                    }
                    // $("#data").append(data.msg);
                    // document.getElementById('#result').innerHTML = data;
                    // $('#result').innerHTML = data
                }
            });
        }
    </script>
    @endsection