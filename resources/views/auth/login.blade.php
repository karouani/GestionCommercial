

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="static/css/bootstrap.min.css">
<link rel="stylesheet" href="static/web-fonts-with-css/css/fontawesome-all.css">
<link rel="stylesheet" href="static/css/mystyle.css">
<body>
<div class="jumbotron jumbotron-fluid">
<div class="container">

    <div class="row">
            <div class="col-md-6 mycolb col-sm-12">
                <br>
                    <h1 class="display-4">Gestion Commercial</h1>
                    <p class="lead">
                            Bienvenue sur notre application web: 
                                gére les entrees/sorties et la facturation d entreprise </p>
            </div>

        <div class="col">
                <form method="POST" action="{{ route('login') }}">
                        <div class="card">
                <div class="card-header myfontcolor">{{ __('Login') }}</div>

                <div class="card-body">

                        @csrf

                        <div class="form-group ">
                            <label for="exampleInputEmail1" class="myfontcolor">{{ __('E-Mail Address') }}</label>

                            
                                <input id="exampleInputEmail1" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" aria-describedby="emailHelp" placeholder="Enter email" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group ">
                            <label for="exampleInputPassword1" class="myfontcolor">{{ __('Password') }}</label>

                           
                                <input id="exampleInputPassword1" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            
                        </div>

                       

                      
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</body>