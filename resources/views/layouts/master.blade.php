<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="google-site-verification" content="uskn-FT3QfFM7yfqC4EvmUT0nxOUnL479NjEHNe08qg" />
        <meta name='yandex-verification' content='41c0e159868affa4' />
		<link rel="shortcut icon" type="image/x-icon" href="{{ asset('/css/favicon.ico') }}">
        @yield('meta')
        <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/jquery.fancybox.css?v=2.1.5') }}" rel="stylesheet">
        <link href="{{ asset('/css/helpers/jquery.fancybox-thumbs.css?v=1.0.7') }}" rel="stylesheet">
        <link href="{{ asset('/css/helpers/jquery.fancybox-buttons.css?v=1.0.5') }}" rel="stylesheet">
        <link href="{{ asset('/css/bootstrap-switch.css') }}" rel="stylesheet">

        <!-- Fonts -->
        <link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    
    </head>
    <body>

        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">

                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    @if (isset($site_name))
                    <a class="navbar-brand" href="/">{{$site_name}} (18+)</a>

                    @else
                    <a class="navbar-brand" href="/">{!!Request::server ('HTTP_HOST')!!} (18+)</a>
                    @endif

                </div>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">

                        <li class="hidden-sm"><a href="/search">Поиск</a></li>

                        @if (isset($categories))
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Категории <b class="caret"></b></a>
                            <ul class="dropdown-menu scrollable-menu">

                                <li><a  href="/" title="Все категории">Все</a></li>
                                @foreach ($categories as $category)
                                  @if ($category->slug!='all')
                                  <li >

                                      <a class="various"  href="/category/{{ $category->slug}}" title="{{ $category->title }}">{{ $category->title }}</a>

                                  </li>
                                  @endif
                                @endforeach
                            </ul>
                        </li>
                        @endif


                </div>
            </div>
        </nav>
        <div class="container">
            @if (Session::has('message'))
            <div class="flash alert-info">
                <p>{!! Session::get('message') !!}</p>
            </div>
            @endif
            @if ($errors->any())
            <div class='flash alert-danger'>
                @foreach ( $errors->all() as $error )
                <p>{{ $error }}</p>
                @endforeach
            </div>
            @endif
        </div>

        @yield('content')

        @include('_partials.footer')

    </body>
</html>

