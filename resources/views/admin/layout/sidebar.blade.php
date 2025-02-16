<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">Stisla</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">St</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Fundamentals</li>
            <li class="@if(Route::is("admin.index")) active @endif">
                <a class="nav-link" href="{{ route("admin.index") }}"><i class="fas fa-fire"></i> <span>Dashboard</span></a>
            </li>
            <li class="dropdown @if(Route::is("admin.categories") || Route::is("admin.category.add")) active @endif">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"> <i class="fas fa-folder"></i> <span>Categorise</span></a>
                <ul class="dropdown-menu">
                    <li class="@if(Route::is("admin.categories")) active @endif">
                        <a class="nav-link" href="{{ route("admin.categories") }}">Categories</a>
                    </li>
                    <li class="@if(Route::is("admin.category.add")) active @endif">
                        <a class="nav-link" href="{{ route("admin.category.add") }}">Add Category</a>
                    </li>
                </ul>
            </li>
            <li class="menu-header">Sections</li>
            <li class="dropdown @if(Route::is("admin.slides") || Route::is("admin.slide.add")) active @endif">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"> <i class="fa-solid fa-image"></i> <span>Slides</span></a>
                <ul class="dropdown-menu">
                    <li class="@if(Route::is("admin.slides")) active @endif"><a class="nav-link" href="{{ route("admin.slides") }}">Slides</a></li>
                    <li class="@if(Route::is("admin.slide.add")) active @endif"><a class="nav-link" href="{{ route("admin.slide.add") }}">Add Slide</a></li>
                </ul>
            </li>
            <li class="dropdown @if(Route::is("admin.why_chooses") || Route::is("admin.why_choose.add")) active @endif">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"> <i class="fas fa-check-circle"></i> <span>Why Chooses</span></a>
                <ul class="dropdown-menu">
                    <li class="@if(Route::is("admin.why_chooses")) active @endif"><a class="nav-link" href="{{ route("admin.why_chooses") }}">Why Chooses</a></li>
                    <li class="@if(Route::is("admin.why_choose.add")) active @endif"><a class="nav-link" href="{{ route("admin.why_choose.add") }}">Add Choose</a></li>
                </ul>
            </li>
            <li class="menu-header">Products</li>
            <li class="dropdown @if(Route::is("admin.products") || Route::is("admin.product.add")) active @endif">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Products</span></a>
                <ul class="dropdown-menu">
                    <li class="@if(Route::is("admin.products")) active @endif"><a class="nav-link" href="{{ route("admin.products") }}">Products</a></li>
                    <li class="@if(Route::is("admin.product.add")) active @endif"><a class="nav-link" href="{{ route("admin.product.add") }}">Add Product</a></li>
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