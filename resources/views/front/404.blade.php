@extends("front.layout.app")
@section("title", "404 Not Found")
@section("content")
<!--=============================
    404 PAGE START
==============================-->
<section class="fp__404">
    <div class="container">
        <div class="row">
            <div class="col-xl-5 col-md-7 m-auto">
                <div class="fp__404_text wow fadeInUp" data-wow-duration="1s">
                    <img src="images/404_img.png" alt="404" class="img-fluid w-100">
                    <h2>That Page Doesn't Exist!</h2>
                    <p>Sorry, the page you were looking for could not be found.</p>
                    <a class="common_btn" href="{{ route("front.index") }}">home</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!--=============================
    404 PAGE END
==============================-->
@endsection