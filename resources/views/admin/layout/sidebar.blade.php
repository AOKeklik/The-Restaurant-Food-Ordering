<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">Stisla</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">St</a>
        </div>
        <ul class="sidebar-menu">
            {{-- fundamental --}}
            <li class="menu-header">Fundamentals</li>
            <li class="@if(Route::is("admin.index")) active @endif">
                <a class="nav-link" href="{{ route("admin.index") }}"><i class="fas fa-fire"></i> <span>Dashboard</span></a>
            </li>
            <li class="dropdown @if(Route::is("admin.settings")) active @endif">
                <a class="nav-link" href="{{ route("admin.settings") }}"><i class="far fa-cogs"></i> <span>Settings</span></a>
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

            {{-- section --}}
            <li class="menu-header">Sections</li>
            <li class="dropdown @if(Route::is("admin.setting.slides") || Route::is("admin.setting.slide.add")) active @endif">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"> <i class="fa-solid fa-image"></i> <span>Slides</span></a>
                <ul class="dropdown-menu">
                    <li class="@if(Route::is("admin.setting.slides")) active @endif"><a class="nav-link" href="{{ route("admin.setting.slides") }}">Slides</a></li>
                    <li class="@if(Route::is("admin.setting.slide.add")) active @endif"><a class="nav-link" href="{{ route("admin.setting.slide.add") }}">Add Slide</a></li>
                </ul>
            </li>
            <li class="dropdown @if(Route::is("admin.setting.why_chooses") || Route::is("admin.setting.why_choose.add")) active @endif">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"> <i class="fas fa-check-circle"></i> <span>Why Chooses</span></a>
                <ul class="dropdown-menu">
                    <li class="@if(Route::is("admin.setting.why_chooses")) active @endif"><a class="nav-link" href="{{ route("admin.setting.why_chooses") }}">Why Chooses</a></li>
                    <li class="@if(Route::is("admin.setting.why_choose.add")) active @endif"><a class="nav-link" href="{{ route("admin.setting.why_choose.add") }}">Add Choose</a></li>
                </ul>
            </li>
            <li class="dropdown @if(Route::is("admin.setting.menu")) active @endif">
                <a class="nav-link" href="{{ route("admin.setting.menu") }}"><i class="far fa-pizza-slice"></i> <span>Menu</span></a>
            </li> 

            {{-- customer --}}
            <li class="menu-header">Customer</li>
            <li class="dropdown @if(Route::is("admin.delivery_areas") || Route::is("admin.delivery_area.add")) active @endif">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-map-marker-alt"></i> <span>Delivery Areas</span></a>
                <ul class="dropdown-menu">
                    <li class="@if(Route::is("admin.delivery_areas")) active @endif">
                        <a class="nav-link" href="{{ route("admin.delivery_areas") }}">Delivery Areas</a>
                    </li>
                    <li class="@if(Route::is("admin.delivery_area.add")) active @endif">
                        <a class="nav-link" href="{{ route("admin.delivery_area.add") }}">Add Area</a>
                    </li>
                </ul>
            </li>

            {{-- restaurant --}}
            <li class="menu-header">Restaurant</li>
            <li class="dropdown @if(Route::is("admin.products") || Route::is("admin.product.add")) active @endif">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-shopping-bag"></i> <span>Products</span></a>
                <ul class="dropdown-menu">
                    <li class="@if(Route::is("admin.products")) active @endif"><a class="nav-link" href="{{ route("admin.products") }}">Products</a></li>
                    <li class="@if(Route::is("admin.product.add")) active @endif"><a class="nav-link" href="{{ route("admin.product.add") }}">Add Product</a></li>
                </ul>
            </li>
            <li class="dropdown @if(Route::is("admin.options") || Route::is("admin.option.add")) active @endif">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"> <i class="fas fa-sliders-h"></i> <span>Options</span></a>
                <ul class="dropdown-menu">
                    <li class="@if(Route::is("admin.options")) active @endif">
                        <a class="nav-link" href="{{ route("admin.options") }}">Options</a>
                    </li>
                    <li class="@if(Route::is("admin.category.add")) active @endif">
                        <a class="nav-link" href="{{ route("admin.option.add") }}">Add Option</a>
                    </li>
                </ul>
            </li>
            <li class="dropdown @if(Route::is("admin.coupons") || Route::is("admin.coupon.add")) active @endif">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-ticket-alt"></i> <span>Coupons</span></a>
                <ul class="dropdown-menu">
                    <li class="@if(Route::is("admin.coupons")) active @endif"><a class="nav-link" href="{{ route("admin.coupons") }}">Coupons</a></li>
                    <li class="@if(Route::is("admin.coupon.add")) active @endif"><a class="nav-link" href="{{ route("admin.coupon.add") }}">Add Coupon</a></li>
                </ul>
            </li>
            <li class="dropdown @if(Request::is("admin/payment/*")) active @endif">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fa-solid fa-credit-card"></i> <span>Payments</span></a>
                <ul class="dropdown-menu">
                    <li class="@if(Route::is("admin.payment.paypal.edit")) active @endif"><a class="nav-link" href="{{ route("admin.payment.paypal.edit") }}">Paypal</a></li>
                    <li class="@if(Route::is("admin.payment.stripe.edit")) active @endif"><a class="nav-link" href="{{ route("admin.payment.stripe.edit") }}">Stripe</a></li>
                    <li class="@if(Route::is("admin.payment.razorpay.edit")) active @endif"><a class="nav-link" href="{{ route("admin.payment.razorpay.edit") }}">Razorpay</a></li>
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