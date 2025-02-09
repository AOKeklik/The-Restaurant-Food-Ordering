@include("admin.layout.header")

<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
        </ul>
    </form>
    <ul class="navbar-nav navbar-right">
        <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
        <img alt="image" src="{{ asset("uploads/admin") }}/{{ Auth::guard("user")->user()->avatar }}" class="rounded-circle mr-1">
        <div class="d-sm-none d-lg-inline-block">{{ Auth::guard("user")->user()->name }}</div></a>
        <div class="dropdown-menu dropdown-menu-right">
            <div class="dropdown-title">Logged in 5 min ago</div>
            <a href="{{ route("admin.profile.edit") }}" class="dropdown-item has-icon">
            <i class="far fa-user"></i> Profile
            </a>
            <a href="features-activities.html" class="dropdown-item has-icon">
            <i class="fas fa-bolt"></i> Activities
            </a>
            <a href="features-settings.html" class="dropdown-item has-icon">
            <i class="fas fa-cog"></i> Settings
            </a>
            <div class="dropdown-divider"></div>
            <a href="{{ route("admin.signout.submit") }}" class="dropdown-item has-icon text-danger">
            <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
        </li>
    </ul>
</nav>

@include("admin.layout.sidebar")

<div class="main-content">
    <section class="section">
        <div class="section-header justify-content-between">
            <h1>@yield("title", "Admin")</h1>
            <a target="_blank" href="@yield("link",route("front.index"))" class="btn btn-primary">
                <i class="fa fa-eye"></i>
                Frontend
            </a>
        </div>
    </section>

@yield("content")

</div>

@include("admin.layout.footer")
