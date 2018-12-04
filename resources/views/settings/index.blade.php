@extends ('layouts.master')

@section('content')

<div class="nav-wrapper">
    @include('pages.nav')
</div>

    <div class="settings-page">

        <div class="page-title-row">
            <h2>Settings</h2>
        </div>

        <div class="row">

            <div class="col-md-3">

                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link active" id="v-pills-account-tab" data-toggle="pill" href="#v-pills-account" role="tab" aria-controls="v-pills-account" aria-selected="true">Account</a>
                    <a class="nav-link" id="v-pills-privacy-tab" data-toggle="pill" href="#v-pills-privacy" role="tab" aria-controls="v-pills-privacy" aria-selected="false">Privacy</a>
                    <a class="nav-link" id="v-pills-email-tab" data-toggle="pill" href="#v-pills-email" role="tab" aria-controls="v-pills-email" aria-selected="false">Email & Notifications</a>
                </div>

            </div>

            <div class="col-md-9">

                <div class="tab-content" id="v-pills-tabContent">
                  
                  <div class="tab-pane fade show active" id="v-pills-account" role="tabpanel" aria-labelledby="v-pills-account-tab">
                      account
                  </div>
                  
                  <div class="tab-pane fade" id="v-pills-privacy" role="tabpanel" aria-labelledby="v-pills-privacy-tab">
                      privacy
                  </div>

                  <div class="tab-pane fade" id="v-pills-email" role="tabpanel" aria-labelledby="v-pills-email-tab">
                      email
                  </div>
                </div>

            </div>

        </div>

    </div>


@endsection
