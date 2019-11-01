<!DOCTYPE html>
 
<html lang="en">
    <head>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@isset($title)
            {{$title}}
        @endisset
    </title>
    @include('css')
    </head>
    <body class="hold-transition sidebar-mini">
    
        <div class="wrapper">
            @include('admin/sidebar')
            @include('admin/header')
            <div class="content-wrapper">
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark">@yield('head')</h1>
                        </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.container-fluid -->
                </div>
                <div class="content">
                    <div class="container-fluid">
                        <div class ="col-md-8">
                            @if(session('message'))
                                <div class="alert alert-success">
                                    {{session('message')}}
                                </div>
                            @endif    
                        </div>
                        @yield('content')
                        
                    </div>
                </div>
            </div>        
        </div>
        @include('javscript')
        @yield('script')            
    </body>
</html>