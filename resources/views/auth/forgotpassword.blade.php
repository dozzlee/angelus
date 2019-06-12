@extends('layouts.master')

@section('Digital shop', 'Page Title')

@section('sidebar')
    @parent
@endsection

@section('content')
    <div class="container">
        <div id="loginbox" style="margin-top:50px;" class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
          @if (session()->has('successful'))
              <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-success"><strong>{{session()->get('successful')}}</strong></div>
                </div>
              </div>
          @endif
          <div class="panel panel-default" >
                <div class="panel-heading accent-bg-1 accent-0">
                    <div class="panel-title" style="text-align:center;">Forgot Password</div>
                </div>
                <div style="padding-top:30px" class="panel-body" >
                    <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>
                    <form method="POST" action="{{route('forgot-password')}}" class="form-horizontal" role="form">
                        {!! csrf_field() !!}
                        <fieldset>
                          <span class="help-block">
                            <i class="fa fa-info"></i> Email address you use to log in to your account
                            <br>
                            We'll send you an email with instructions to choose a new password.
                          </span>
                          <div class="form-group input-group">
                            <span class="input-group-addon">
                              @
                            </span>
                            <input class="form-control" placeholder="Email" name="email" type="email" required="">
                          </div>
                          <button type="submit" class="btn btn-primary btn-block accent-bg-5">
                            Continue
                          </button>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
