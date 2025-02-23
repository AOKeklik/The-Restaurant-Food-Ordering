<!--=============================
    TOPBAR START
==============================-->
<section class="fp__topbar">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 col-md-8">
                <ul class="fp__topbar_info d-flex flex-wrap">
                    <li><a href="mailto{{ $provider_settings->site_email }}"><i class="fas fa-envelope"></i> {{ $provider_settings->site_email }}</a>
                    </li>
                    <li><a href="callto:{{ $provider_settings->site_phone }}"><i class="fas fa-phone-alt"></i> {{ $provider_settings->site_phone }}</a></li>
                </ul>
            </div>
            <div class="col-xl-6 col-md-4 d-none d-md-block">
                <ul class="topbar_icon d-flex flex-wrap">
                    <li><a href=" {{ $provider_settings->link_facebook }}"><i class="fab fa-facebook-f"></i></a> </li>
                    <li><a href=" {{ $provider_settings->link_linkedin }}"><i class="fab fa-linkedin-in"></i></a> </li>
                    <li><a href=" {{ $provider_settings->link_behance }}"><i class="fab fa-behance"></i></a> </li>
                    <li><a href=" {{ $provider_settings->link_twitter }}"><i class="fab fa-twitter"></i></a> </li>
                </ul>
            </div>
        </div>
    </div>
</section>
<!--=============================
    TOPBAR END
==============================-->