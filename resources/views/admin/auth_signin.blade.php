@include("admin.layout.header")
    <section class="section">
        <div class="container mt-5">
            <div class="row">
                <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                    <a href="{{ route("front.index") }}" class="login-brand d-block">
                        <img src="{{ asset("dist/back/img/stisla-fill.svg") }}" alt="logo" width="100" class="shadow-light rounded-circle">
                    </a>

                    <div class="card card-primary">
                        <div class="card-header"><h4>Login</h4></div>

                        <div class="card-body">
                            <form method="POST" action="{{ route("admin.signin.submit") }}" class="needs-validation" novalidate="">
                                @csrf
                                @method("POST")
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input value="{{ old("email") }}" id="email" type="email" class="form-control @error("email") is-invalid @enderror" name="email" tabindex="1" required autofocus>
                                    <div class="invalid-feedback">
                                        Please fill in your email
                                    </div>
                                    @error("email")  <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
                                </div>

                                <div class="form-group">
                                    <div class="d-block">
                                        <label for="password" class="control-label">Password</label>
                                        <div class="float-right">
                                        <a href="{{ route("admin.forget") }}" class="text-small">
                                            Forgot Password?
                                        </a>
                                        </div>
                                    </div>
                                    <input value="{{ old("password") }}" id="password" type="password" class="form-control @error("password") is-invalid @enderror" name="password" tabindex="2" required>
                                    <div class="invalid-feedback">
                                        please fill in your password
                                    </div>
                                    @error("password")  <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me">
                                        <label class="custom-control-label" for="remember-me">Remember Me</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                        Login
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