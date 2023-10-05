<x-front-layout title="Login">

    <!-- Titlebar -->
    <div id="titlebar" class="gradient">
        <div class="container">
            <div class="row">
                <div class="col-md-12">

                    <h2>Verify Code</h2>

                    <!-- Breadcrumbs -->
                    <nav id="breadcrumbs" class="dark">
                        <ul>
                            <li><a href="#">{{ __('Home') }}</a></li>
                            <li>Verify Code</li>
                        </ul>
                    </nav>

                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-xl-5 offset-xl-3">


                <div class="login-register-page">
                    <!-- Welcome Text -->
                    <div class="welcome-text">
                        <h3>{{ __("We're glad to see you again!") }}</h3>
                        @if (Route::has('register'))
                        <span>{{ __("Don't have an account?") }} <a href="{{ route('register') }}">Sign Up!</a></span>
                        @endif
                    </div>

                    <!-- Session Status -->
                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <!-- Validation Errors -->
                    <!-- <x-auth-validation-errors class="mb-4" :errors="$errors" /> -->
                    <x-flash-message />

                    <!-- Form -->
                    <form method="post" action="{{ route('otp.verify') }}" id="login-form">
                        @csrf

                        <div class="input-with-icon-left">
                            <i class="icon-material-outline-phone"></i>
                            <input type="text" class="input-text with-border" name="code" id="code" placeholder="{{ __('Enter Code') }}" required />
                        </div>
                    </form>

                    <!-- Button -->
                    <button class="button full-width button-sliding-icon ripple-effect margin-top-10" type="submit" form="login-form">Send<i class="icon-material-outline-arrow-right-alt"></i></button>
                </div>

            </div>
        </div>
    </div>

    <!-- Spacer -->
    <div class="margin-top-70"></div>
    <!-- Spacer / End-->

</x-front-layout>
