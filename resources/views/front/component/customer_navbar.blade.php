<div class="col-xl-3 col-lg-4 wow fadeInUp" data-wow-duration="1s">
    <div class="fp__dashboard_menu">
        <div class="dasboard_header">
            <div class="dasboard_header_img">
                <img src="{{ asset("uploads/customer") }}/{{ Auth::guard("user")->user()->avatar }}" alt="user" class="img-fluid w-100">
                <label for="upload"><i class="far fa-camera"></i></label>
                <input type="file" id="upload" hidden>
            </div>
            <h2>{{ Auth::guard("user")->user()->name }}</h2>
        </div>
        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
            aria-orientation="vertical">
            <button class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill"
                data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home"
                aria-selected="true"><span><i class="fas fa-user"></i></span> Parsonal Info</button>

            <button class="nav-link" id="v-pills-address-tab" data-bs-toggle="pill"
                data-bs-target="#v-pills-address" type="button" role="tab"
                aria-controls="v-pills-address" aria-selected="true"><span><i
                        class="fas fa-user"></i></span>address</button>

            <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill"
                data-bs-target="#v-pills-profile" type="button" role="tab"
                aria-controls="v-pills-profile" aria-selected="false"><span><i
                        class="fas fa-bags-shopping"></i></span> Order</button>

            <button class="nav-link" id="v-pills-messages-tab2" data-bs-toggle="pill"
                data-bs-target="#v-pills-messages2" type="button" role="tab"
                aria-controls="v-pills-messages2" aria-selected="false"><span><i
                        class="far fa-heart"></i></span> wishlist</button>

            <button class="nav-link" id="v-pills-messages-tab" data-bs-toggle="pill"
                data-bs-target="#v-pills-messages" type="button" role="tab"
                aria-controls="v-pills-messages" aria-selected="false"><span><i
                        class="fas fa-star"></i></span> Reviews</button>

            <button class="nav-link" id="v-pills-settings-tab" data-bs-toggle="pill"
                data-bs-target="#v-pills-settings" type="button" role="tab"
                aria-controls="v-pills-settings" aria-selected="false"><span><i
                        class="fas fa-user-lock"></i></span> Change Password </button>

            <form method="POST" action="{{ route("front.customer.signout.submit") }}">
                @csrf
                @method("POST")
                <button class="nav-link w-100" type="submit">
                    <span> <i class="fas fa-sign-out-alt"></i></span> 
                    Logout
                </button>
            </form>
        </div>
    </div>
</div>