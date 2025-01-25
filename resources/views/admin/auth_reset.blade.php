@include("admin.layout.header")
<section class="section">
    <div class="container mt-5">
        <div class="row">
            <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="login-brand">
                <img src="{{ asset("dist/back/img/stisla-fill.svg") }}" alt="logo" width="100" class="shadow-light rounded-circle">
            </div>

            <div class="card card-primary">
                <div class="card-header"><h4>Reset Password</h4></div>

                <div class="card-body">
                    <p class="text-muted">We will send a link to reset your password</p>
                    <form method="POST" action="{{ route("admin.reset.submit") }}" class="needs-validation">
                        @csrf
                        @method("POST")
                        <input type="hidden" name="remember_token" value="{{ $token }}">
                        <input type="hidden" name="email" value="{{ $email }}">

                        <div class="form-group">
                            <label for="password">New Password</label>
                            <input id="password" type="password" class="form-control pwstrength @error("password") is-invalid @enderror" data-indicator="pwindicator" name="password" tabindex="1">
                            @error("password")  <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
                            <div id="pwindicator" class="pwindicator">
                                <div class="bar"></div>
                                <div class="label"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm">Confirm Password</label>
                            <input id="password-confirm" type="password" class="form-control @error("confirm-password") is-invalid @enderror" name="confirm-password" tabindex="2">
                            @error("confirm-password") <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                Reset Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="simple-footer">
                Copyright &copy; Stisla 2018
            </div>
            </div>
        </div>
    </div>
</section>
@include("admin.layout.footer")
