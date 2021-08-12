<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="">
    <meta name="description" content="">

    <title>Snapshot HTML CSS Web Template</title>
    <!--
Snapshot Template
http://www.templatemo.com/tm-493-snapshot

Zoom Slider
https://vegas.jaysalvat.com/

Caption Hover Effects
http://tympanus.net/codrops/2013/06/18/caption-hover-effects/
-->

    <!-- <link rel="stylesheet" href="fresher/css/animate.min.css">
    <link rel="stylesheet" href="fresher/css/font-awesome.min.css">
    <link rel="stylesheet" href="fresher/css/component.css">

    <link rel="stylesheet" href="fresher/css/owl.theme.css">
    <link rel="stylesheet" href="fresher/css/owl.carousel.css">
    <link rel="stylesheet" href="fresher/css/vegas.min.css"> -->
    <link rel="stylesheet" href="fresher/css/style.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- <link href="/demo/fresher.css" rel="stylesheet" /> -->
    <!-- Google web font  -->
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700,300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
</head>

<body>

    <div class="wrapper" style="    position: relative;
    top: 0;
    height: 100vh;">
        <!-- Preloader section -->

        <div class="preloader">
            <div class="sk-spinner sk-spinner-pulse"></div>
        </div>


        <!-- Navigation section  -->

        {{View:: make('fresher.layout.navbar')}}


        <!-- Home section -->

        <!-- <section id="home">
        <div class="overlay"></div>
        <div class="container">
            <div class="row">

                <div class="col-md-offset-1 col-md-10 col-sm-12 wow fadeInUp" data-wow-delay="0.3s">
                    <h1 class="wow fadeInUp" data-wow-delay="0.6s">Let's take a snapshot</h1>
                    <p class="wow fadeInUp" data-wow-delay="0.9s">Snapshot website template is available for free download. Anyone can modify and use it for any site. Please tell your friends about <a rel="nofollow" href="http://www.templatemo.com">templatemo</a>. Thank you.</p>
                    <a href="#about" class="smoothScroll btn btn-success btn-lg wow fadeInUp" data-wow-delay="1.2s">Learn more</a>
                </div>

            </div>
        </div>
    </section> -->








        @yield('content')
        <!-- Footer section -->

        {{View:: make('fresher.layout.footer')}}

    </div> <!-- Back top -->
    <a href="#" class="go-top"><i class="fa fa-angle-up"></i></a>

    <!-- Javascript  -->
    <script src="fresher/js/jquery.js"></script>
    <!-- <script src="fresher/js/bootstrap.min.js"></script> -->



    <script src="fresher/js/custom.js"></script>

</body>

</html>