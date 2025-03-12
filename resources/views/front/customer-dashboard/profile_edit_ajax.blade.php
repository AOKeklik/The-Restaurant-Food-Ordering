<form data-form="profile-update">
    <div class="row">
        <div class="col-12">
            <div class="fp__comment_imput_single">
                <label>name</label>
                <input type="text" placeholder="Name" id="name" name="name" value="{{ Auth::guard("user")->user()->name }}">
                <small data-alert="profile-update-name" class="form-text text-danger"></small>
            </div>
        </div>
        <div class="col-12">
            <div class="fp__comment_imput_single">
                <label>email</label>
                <input type="email" placeholder="Email" id="email" name="email" value="{{ Auth::guard("user")->user()->email }}">
                <small data-alert="profile-update-email" class="form-text text-danger"></small>
            </div>
        </div>
        <div class="col-xl-12">
            <button data-btn="profile-update" type="submit" class="common_btn">submit</button>
        </div>
    </div>
</form>