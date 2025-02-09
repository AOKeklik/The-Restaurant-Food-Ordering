<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">Stisla</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">St</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="@if(Route::is("admin.index")) active @endif">
                <a class="nav-link" href="{{ route("admin.index") }}"><i class="fas fa-fire"></i> <span>Dashboard</span></a>
            </li>
            <li class="menu-header">Slider</li>
            <li class="dropdown @if(Route::is("admin.slides") || Route::is("admin.slide.add")) active @endif">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"> <i class="fa-solid fa-image"></i> <span>Slides</span></a>
                <ul class="dropdown-menu">
                    <li class="@if(Route::is("admin.slides")) active @endif"><a class="nav-link" href="{{ route("admin.slides") }}">Slides</a></li>
                    <li class="@if(Route::is("admin.slide.add")) active @endif"><a class="nav-link" href="{{ route("admin.slide.add") }}">Add Slide</a></li>
                </ul>
            </li>

            {{-- <li class="menu-header">Starter</li>
            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Layout</span></a>
                <ul class="dropdown-menu">
                <li><a class="nav-link" href="layout-default.html">Default Layout</a></li>
                <li><a class="nav-link" href="layout-transparent.html">Transparent Sidebar</a></li>
                <li><a class="nav-link" href="layout-top-navigation.html">Top Navigation</a></li>
                </ul>
            </li>
            <li>
                <a class="nav-link" href="blank.html"><i class="far fa-square"></i> <span>Blank Page</span></a>
            </li> --}}
        </ul>      
    </aside>
</div>