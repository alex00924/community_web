@extends($templatePath.'.shop_layout')

@section('main')

    <section id="form-login"><!--form-->
        <div class="container">
            <h2 class="title text-center">{{ $title }}</h2>
            <div class="row login-form-container">
                <div class="col-sm-3 col-sm-offset-2">
                    <div class="login-form"><!--login form-->
                        @include($templatePath.'.auth.login')
                    </div><!--/login form-->
                </div>

                <div class="col-sm-2">
                    <div class="or">OR</div>
                </div>

                <div class="col-sm-3">
                    <div class="signup-form"><!--sign up form-->
                        @include($templatePath.'.auth.register')
                    </div><!--/sign up form-->
                </div>
            </div>
        </div>
    </section><!--/form-->
@endsection

@section('breadcrumb')
    <div class="breadcrumbs">
        <ol class="breadcrumb">
          <li><a href="{{ route('home') }}">{{ trans('front.home') }}</a></li>
          <li class="active">{{ $title }}</li>
        </ol>
      </div>
@endsection
