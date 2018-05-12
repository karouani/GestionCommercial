<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">



          <!-- Fonts -->
          <link rel="stylesheet" href="{{asset('css/fontawesome-all.css')}}">
          <!-- plugins:css -->
           <link rel="stylesheet" href="{{asset('css/simple-line-icons.css')}}">
          <!-- Styles -->

        <!--   <link rel="stylesheet" href="{{asset('css/font-awesome/webfonts/fa-solid-900.woff2')}}">-->
          <link rel="stylesheet" href="{{asset('css/styles.css')}}">


          
        
    </head>
    <body class="sidebar-fixed header-fixed">
       <div id="app">    
       @if ( $role==="Super Admin" || $role==="Admin")   
         <app-vue></app-vue>
      @elseif ($role==="Expert Comptable")
        <app-vue-comptable></app-vue-comptable>
       @endif

         
       </div>
     <script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>
    
      
     <script src="{{asset('js/carbon.js')}}"></script>
     <script src="{{asset('js/demo.js')}}"></script>
     <script src="{{asset('js/app.js')}}"></script>
    </body>
</html>
