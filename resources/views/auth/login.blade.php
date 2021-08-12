@extends('admin.layouts.app')

@section('content')
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
<div id="snackbar">

@if($errors->any())
   {{$errors->first()}}
   @endif</div>
<div class="container1" style="opacity: 0.9;" >
    <div class="row justify-content-center" style="margin-top: 5%;">
        <div class="col-md-4">
            <div class="card" style="border: none;">

                <div class="card-body">
                <div style="text-align: center;margin-bottom: 5%;"><h5><strong>LOGIN</strong></h5></div>

                    <form method="POST" action="/login_admin">
                        @csrf

                       
                        <div class="form-group row">
                           

                            <div class="col-md-12">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email"  placeholder="Email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                          

                            <div class="col-md-12">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                          

                            <div class="col-md-12">
                            <button type="submit" class=" btn btn-primary btn-lg btn-block" style="background-color: #14043c; border-color: white;">
                                    {{ __('Login') }}
                                </button>

                            </div>
                        </div>


                       
                        <!-- <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div> -->

                        
                    </form>
                    <button class="btn btn-primary btn-lg btn-block" style="border-color:white ; background-color: #F02B38;" class="form-group row">
                            <a href="{{route('login.google')}}" style="color: white;">Login with Google</a>
                      
                        </button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

$(document).ready(function() {
               
                <?php if ($errors->any()) { ?>
                    var x = document.getElementById("snackbar");
                    x.className = "show";
                    setTimeout(function() {
                        x.className = x.className.replace("show", "");
                    }, 2000);

                <?php } ?>
            });
</script>
@endsection
