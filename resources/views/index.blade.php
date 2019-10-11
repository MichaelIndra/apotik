<!DOCTYPE html>
 
<html lang="en">
    <head>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@isset($title)
            {{$title}}
        @endisset
    </title>
    @include('javscript')
    </head>
    <body>
    
        <div class="container">
            @yield('head')
            <div class ="col-md-12">
                @if(session('message'))
                    <div class="alert alert-success">
                        {{session('message')}}
                    </div>
                @endif    
            </div>
            @yield('content')
            @yield('script')
        </div>    
    </body>
</html>