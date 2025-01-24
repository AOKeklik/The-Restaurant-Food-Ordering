@include("admin.layout.header")
    <section class="section">
        <div class="container mt-5">
            <div class="row">
                <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                    <div class="login-brand">
                        <img src="{{ asset("dist/img/stisla-fill.svg") }}" alt="logo" width="100" class="shadow-light rounded-circle">
                    </div>

                    <div class="card card-primary">
                        <div class="card-header"><h4>Forgot Password</h4></div>

                        <div class="card-body">
                        <p class="text-muted">We will send a link to reset your password</p>
                            <form method="POST" action="{{ route("admin.forget.submit") }}">
                                @csrf
                                @method("POST")
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <div class="float-right">
                                        <a href="{{ route("admin.login") }}" class="text-small">
                                            Go back login page!
                                        </a>
                                    </div>
                                    <input value="{{ old("email") }}" id="email" type="email" class="form-control @error("email") is-invalid @enderror" name="email" tabindex="1" required autofocus>
                                    @error("email") <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                        Forgot Password
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