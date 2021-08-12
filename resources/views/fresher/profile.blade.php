@extends('fresher.layout.master')
@section("content")
<!-- <link href="/css/now-ui-dashboard.css?v=1.5.0" rel="stylesheet" /> -->
<style>
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
        left: 50%;
        bottom: 30px;
        font-size: 17px;
    }

    #snackbar.show {
        visibility: visible;
        opacity: 0.7;
    }
</style>
<section id="home" style="width: 100%; height:300px ; background-repeat: no-repeat;background-image: url('/img/bghome.jpg'); background-size: auto;">
    <div class="overlay" style="height:305px ;"></div>
    <div class="container">
        <div class="row" style="margin-right: 10%;margin-left: 10%;">

            <div class="col-md-offset-1 col-sm-12 wow fadeInUp" data-wow-delay="0.3s">
                <h1 class="wow fadeInUp" data-wow-delay="0.6s">profile</h1>
                <p class="wow fadeInUp" data-wow-delay="0.9s">Snapshot website template is available for free download. Anyone can modify and use it for any site. Please tell your friends about <a rel="nofollow" href="http://www.templatemo.com">templatemo</a>. Thank you.</p>

            </div>

        </div>
    </div>
</section>


<div id="snackbar">
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>

    @endforeach
</div>

<!-- change ava -->
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



                            <button type="submit" name="submit" class="btn1 submit-btn"> Submit</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
<!-- ///////////////// -->
<div class="modal fade" id="resetPass" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div style="text-align: center;margin-top:4%;" class="">

                <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
            </div>
            <div class="modal-body" id="">
                <div class="card">
                    <div class="card-header">
                        <h5 class="title">Reset Password</h5>
                    </div>
                    <div class="card-body">
                        <form action="reset_pass" method="POST">
                            @csrf

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Present password</label>
                                        <input type="password" name="pre_pass" class="form-control" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">New password</label>
                                        <input type="password" name="new_pass" id="pass" class="form-control" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Repeat password</label>
                                        <input type="password" name="repeat" id="re_pass" onkeyup="check_repeat_pass()" class="form-control" required>
                                    </div>
                                </div>
                            </div>

                            <div id="check"></div>

                            <!-- onkeydown="return /[a-z, ]/i.test(event.key)" onblur="if (this.value == '') {this.value = '';}" onfocus="if (this.value == '') {this.value = '';}" -->

                    </div>
                    <button type="submit" name="submit" id="submit"> Submit</button>
                    </form>
                </div>
            </div>
        </div>

    </div>

</div>

<div class="content" style="padding: 5%;">
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

                                    <div>
                                        @csrf
                                        <input type="hidden" name="id" id="" value="">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Fullname</label>
                                                    <label for="" class="form-control">{{$user['name']}}</label>
                                                </div>
                                            </div>
                                        </div>


                                        <!-- onkeydown="return /[a-z, ]/i.test(event.key)" onblur="if (this.value == '') {this.value = '';}" onfocus="if (this.value == '') {this.value = '';}" -->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Email address</label>
                                                    <label for="" class="form-control">{{$user['email']}}</label>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Date of birth</label>
                                                    <label for="" class="form-control">{{$user['dob']}}</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 pr-1">
                                                <div class="form-group">
                                                    <label>Part</label>
                                                    <label for="" class="form-control">{{$user['part']}}</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4 px-1">
                                                <div class="form-group">
                                                    <label>Class</label>
                                                    <label for="" class="form-control">{{$user['class']}}</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4 pl-1">
                                                <div class="form-group">
                                                    <label>Phone</label>
                                                    <label for="" class="form-control">{{$user['phone']}}</label>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="" data-toggle="modal" data-target="#resetPass"> Reset password</a>
                                    </div>
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
</div>
<script>
    function check_repeat_pass() {
        var p = document.getElementById('pass').value;
        var p1 = document.getElementById('re_pass').value;
        if (p1 != p) {
            document.getElementById("check").innerHTML = "Unmatch password !";
            document.getElementById("submit").disabled = true;
        } else {
            document.getElementById("check").innerHTML = "Matched password !";
            document.getElementById("submit").disabled = false;
        }
    }

    function set_nav() {
        $(".nav1 li").removeClass("active");
        $('#profile1').addClass('active');
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
    });
</script>
@endsection