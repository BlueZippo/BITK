@extends ('layouts.master')

@section('content')

<div class="nav-wrapper">
    @include('pages.nav')
</div>

    <div class="settings-page">

        <div class="page-title-row">
            
        </div>

        <form>

            <div class="row">

                <div class="col-md-3">

                    <h5>SETTINGS</h5>

                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link active" id="v-pills-account-tab" data-toggle="pill" href="#v-pills-account" role="tab" aria-controls="v-pills-account" aria-selected="true">Account</a>
                        <a class="nav-link" id="v-pills-privacy-tab" data-toggle="pill" href="#v-pills-privacy" role="tab" aria-controls="v-pills-privacy" aria-selected="false">Privacy</a>
                        <a class="nav-link" id="v-pills-email-tab" data-toggle="pill" href="#v-pills-email" role="tab" aria-controls="v-pills-email" aria-selected="false">Email & Notifications</a>
                        <a class="nav-link" id="v-pills-feedback-tab" data-toggle="pill" href="#v-pills-feedback" role="tab" aria-controls="v-pills-feedback" aria-selected="false">Would Love Your Feedback</a>
                    </div>

                </div>

                <div class="col-md-9">

                    <div class="tab-content" id="v-pills-tabContent">

                        

                            @include('settings.account')
                            @include('settings.privacy')
                            @include('settings.email')
                            @include('settings.feedback')

                        
                      
                    </div>

                </div>

            </div>

        </form>

    </div>


@endsection
