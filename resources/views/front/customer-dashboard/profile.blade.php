<div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
    <div class="fp_dashboard_body">
        <h3>Welcome to your Profile</h3>

        <div class="fp__dsahboard_overview">
            <div class="row">
                <div class="col-xl-4 col-sm-6 col-md-4">
                    <div class="fp__dsahboard_overview_item">
                        <span class="icon"><i class="far fa-shopping-basket"></i></span>
                        <h4>total order <span>(76)</span></h4>
                    </div>
                </div>
                <div class="col-xl-4 col-sm-6 col-md-4">
                    <div class="fp__dsahboard_overview_item green">
                        <span class="icon"><i class="far fa-shopping-basket"></i></span>
                        <h4>Completed <span>(71)</span></h4>
                    </div>
                </div>
                <div class="col-xl-4 col-sm-6 col-md-4">
                    <div class="fp__dsahboard_overview_item red">
                        <span class="icon"><i class="far fa-shopping-basket"></i></span>
                        <h4>cancel <span>(05)</span></h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="fp_dash_personal_info">
            <h4>
                Parsonal Information
                <a href="#" class="dash_info_btn" data-btn="profile-edit">
                    <span class="edit">edit</span>
                    <span class="cancel">cancel</span>
                </a>
            </h4>

            <div data-section="profile-info" class="personal_info_text">
                @include("front.customer-dashboard.profile_info_ajax")
            </div>

            <div data-section="profile-edit" class="fp_dash_personal_info_edit comment_input p-0">
                @include("front.customer-dashboard.profile_edit_ajax")
            </div>
        </div>
    </div>
</div>