

<!-- Bootstrap CSS -->

<link rel="stylesheet" href="static/css/bootstrap.min.css">
<link rel="stylesheet" href="static/web-fonts-with-css/css/fontawesome-all.css">
<link rel="stylesheet" type="text/css" href="login2/css/util.css">
<link rel="stylesheet" type="text/css" href="login2/css/main.css">

<body>
<div class="limiter">
		<div class="container-login100">

                <div class="wrap-login100">
                        <div class="login100-form-title" style="background-image: url(login2/images/bg-01.jpg);">
                            <span class="login100-form-title-1">
                                    Sign In
                                </span>   
                        </div>




                <form class="login100-form validate-form" method="POST" action="{{ route('login') }}">

                    
                        <div class="wrap-input100 validate-input m-b-26" >
           

                        @csrf


                            <span  class="label-input100">E-mail :</span>

                                <input  type="email" class="input100{{ $errors->has('password') ? ' is-invalid' : '' }}  " name="email" value="{{ old('email') }}" aria-describedby="emailHelp" placeholder="Enter Email" required autofocus>
                        </div>
                              
                    


                        
                        <div class="wrap-input100 validate-input m-b-18" >
                                <span class="label-input100">Password</span>

                                <input id="exampleInputPassword1" type="password" class="input100{{ $errors->has('password') ? ' is-invalid' : '' }} " name="password" placeholder="Password" >

                            </div>
                              
                            <br>
                            <br>
                      <div class="err">
                            @if ($errors->has('email'))
                                <span class="">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            @if ($errors->has('password'))
                                <span class="">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                      </div>
                       

                        <div class="container-login100-form-btn">
                                <button type="submit" class="login100-form-btn">
                                    {{ __('Login') }}
                                </button>
                        </div>
                    </form>
             
            </div>
        </div>
    </div>

<!--===============================================================================================-->
	<script src="login2/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="login2/js/main.js"></script>
</body>