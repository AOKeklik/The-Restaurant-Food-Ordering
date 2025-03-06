<!--=============================
    BREADCRUMB START
==============================-->
<section class="fp__breadcrumb" style="background: url(images/counter_bg.jpg);">
    <div class="fp__breadcrumb_overlay">
        <div class="container">
            <div class="fp__breadcrumb_text">
                <h1>@yield("page_title")</h1>
                <ul>
                    <li><a href="{{ route("front.index") }}">home</a></li>
                    <li><a href="javasicript:void(0)">@yield("page_title")</a></li>
                </ul>
            </div>
        </div>
    </div>
</section>
<!--=============================
    BREADCRUMB END
==============================-->