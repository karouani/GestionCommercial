@extends('layouts.app')

@section('content')
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="static/css/bootstrap.min.css">
    <link rel="stylesheet" href="static/web-fonts-with-css/css/fontawesome-all.css">
    <link rel="stylesheet" href="static/css/mystyle.css">
 

    <title>Bienvenue</title>
  </head>

    
      <header>
      <div class="jumbotron jumbotron-fluid">
        <div class="container">
         
          <div class="container">
          <div class="row">
            <div class="col-md-6 mycolb col-sm-12">
                    <h1 class="display-4">Fluid jumbotron</h1>
                    <p class="lead">
                            This is a modified jumbotron that occupies the entire horizontal space of its parent.</p>
                                    </div>
            <div class="col">

                    <form>

                            <div class="card">
                                    <h5 class="card-header myfontcolor">Login </h5>
                                    <div class="card-body">
                                  
                                      <form method="POST" action="{{ route('login') }}">
                                        @csrf
                
                                        <div class="form-group">
                                          <label for="exampleInputEmail1" class="myfontcolor">{{ __('E-Mail Address') }}</label>
                
                                          
                                                <input id="exampleInputEmail1" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" aria-describedby="emailHelp" placeholder="Enter email" name="email" value="{{ old('email') }}" required autofocus>
                                             <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>

                                                @if ($errors->has('email'))
                                                    <span class="invalid-feedback">
                                                        <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                                                @endif
                                            
                                        </div>
                

                                        <div class="form-group">
                                            <label for="exampleInputPassword1" class="myfontcolor">{{ __('Password') }}</label>
                
                                           
                                                <input id="exampleInputPassword1" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Password" name="password" required>
                
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

</header>





    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    @endsection
    















    @extends('layouts.app')

@section('content')

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="static/css/bootstrap.min.css">
<link rel="stylesheet" href="static/web-fonts-with-css/css/fontawesome-all.css">
<link rel="stylesheet" href="static/css/mystyle.css">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-sm-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                       

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection