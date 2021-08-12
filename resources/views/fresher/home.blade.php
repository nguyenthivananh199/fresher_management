@extends('fresher.layout.master')
@section("content")

<section id="home" style=" background-repeat: no-repeat;background-image: url('/img/bghome.jpg');">
  <div class="overlay"></div>
  <div class="container">
    <div class="row" style="margin-left: 10%;margin-right: 10%;">

      <div class="col-md-offset-1 col-sm-12 wow fadeInUp" data-wow-delay="0.3s">
        <h1 class="wow fadeInUp" data-wow-delay="0.6s">Make your work easier</h1>
        <p class="wow fadeInUp" data-wow-delay="0.9s">Snapshot website template is available for free download. Anyone can modify and use it for any site. Please tell your friends about <a rel="nofollow" href="http://www.templatemo.com">templatemo</a>. Thank you.</p>
        <a href="#about" class="smoothScroll btn btn-success btn-lg wow fadeInUp" style="background-color: #f46d04;color:#14043c;border-color: #f46d04;" data-wow-delay="1.2s">Report now</a>
      </div>

    </div>
  </div>
</section>
<script>
  function set_nav() {
            $(".nav1 li").removeClass("active");
            $('#home1').addClass('active');
        }
        $(document).ready(function() {
        set_nav();
      
    });
</script>
@endsection