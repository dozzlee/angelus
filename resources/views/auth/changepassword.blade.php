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
            <div class="panel panel-default">
                <div class="panel-heading accent-bg-1 accent-0">
                    <div class="panel-title" style="text-align:center;">Reset Password</div>
                </div>
                <div style="padding-top:30px" class="panel-body" >
                    <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>
                    <form method="POST" action="{{route('reset-password', $token)}}" class="form-horizontal" role="form">
                        {!! csrf_field() !!}
                        <p> <i class="fa fa-info"> Suggestions for a stronger password are displayed beneath the input fields </i></p>
                        <input type="password" class="input-lg form-control" name="password1" id="password1" placeholder="New Password" autocomplete="off">
                        <div class="row">
                          <div class="col-sm-6">
                            <span id="8char" class="fa fa-remove" style="color:#FF0004;"></span> 8 Characters Long
                            <br>
                            <span id="ucase" class="fa fa-remove" style="color:#FF0004;"></span> One Uppercase Letter

                          </div>
                          <div class="col-sm-6">
                            <span id="lcase" class="fa fa-remove" style="color:#FF0004;"></span> One Lowercase Letter
                            <br>
                            <span id="num" class="fa fa-remove" style="color:#FF0004;"></span> One Number
                          </div>
                        </div>
                        <input type="password" class="input-lg form-control" name="password2" id="password2" placeholder="Repeat Password" autocomplete="off">
                        <div class="row">
                          <div class="col-sm-12">
                            <span id="pwmatch" class="fa fa-remove" style="color:#FF0004;"></span> Passwords Match
                          </div>
                        </div>
                        <input type="submit" class="col-xs-12 btn btn-primary btn-load btn-lg accent-bg-5" data-loading-text="Changing Password..." value="Change Password">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
      $("input[type=password]").keyup(function(){
      var ucase = new RegExp("[A-Z]+");
    	var lcase = new RegExp("[a-z]+");
    	var num = new RegExp("[0-9]+");

    	if($("#password1").val().length >= 8){
    		$("#8char").removeClass("fa-remove");
    		$("#8char").addClass("fa-check-circle");
    		$("#8char").css("color","#00A41E");
    	}else{
    		$("#8char").removeClass("fa-check-circle");
    		$("#8char").addClass("fa-remove");
    		$("#8char").css("color","#FF0004");
    	}

    	if(ucase.test($("#password1").val())){
    		$("#ucase").removeClass("fa-remove");
    		$("#ucase").addClass("fa-check-circle");
    		$("#ucase").css("color","#00A41E");
    	}else{
    		$("#ucase").removeClass("fa-check-circle");
    		$("#ucase").addClass("fa-remove");
    		$("#ucase").css("color","#FF0004");
    	}

    	if(lcase.test($("#password1").val())){
    		$("#lcase").removeClass("fa-remove");
    		$("#lcase").addClass("fa-check-circle");
    		$("#lcase").css("color","#00A41E");
    	}else{
    		$("#lcase").removeClass("fa-check-circle");
    		$("#lcase").addClass("fa-remove");
    		$("#lcase").css("color","#FF0004");
    	}

    	if(num.test($("#password1").val())){
    		$("#num").removeClass("fa-remove");
    		$("#num").addClass("fa-check-circle");
    		$("#num").css("color","#00A41E");
    	}else{
    		$("#num").removeClass("fa-check-circle");
    		$("#num").addClass("fa-remove");
    		$("#num").css("color","#FF0004");
    	}

    	if($("#password1").val() == $("#password2").val()){
    		$("#pwmatch").removeClass("fa-remove");
    		$("#pwmatch").addClass("fa-check-circle");
    		$("#pwmatch").css("color","#00A41E");
    	}else{
    		$("#pwmatch").removeClass("fa-check-circle");
    		$("#pwmatch").addClass("fa-remove");
    		$("#pwmatch").css("color","#FF0004");
    	}
    });
    </script>
@endsection
