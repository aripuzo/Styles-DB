<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]> <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>  <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<html lang="{{ app()->getLocale() }}" class="js" style="">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="fb:app_id" content="174567093039185" />
    <meta property="fb:admins" content="{YOUR_PROFILE_ID}"/>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {!! SEO::generate() !!}

    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('images/fav/apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('images/fav/apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('images/fav/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('images/fav/apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('images/fav/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('images/fav/apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('images/fav/apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('images/fav/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/fav/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192"  href="{{ asset('images/fav/android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/fav/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('images/fav/favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/fav/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('images/fav/manifest.json') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('images/fav/ms-icon-144x144.png') }}">
    <meta name="theme-color" content="#ffffff">

    <!-- Styles -->
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
    <!-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
    <link href='http://fonts.googleapis.com/css?family=Fira+Sans:300,400,700,300italic,400italic%7cHind:400,300,700%7cTeko' rel='stylesheet' type='text/css'>
    <link href="{{ asset('css/css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/settings.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/layers.css') }}">
    @yield('styles')
    <style>
        #search-list{float:left;list-style:none;margin-top:-3px;padding:0;width:190px;position: absolute;}
        #search-list li{padding: 10px; background: #f0f0f0; border-bottom: #bbb9b9 1px solid; z-index:10;}
        #search-list li:hover{background:#ece3d2;cursor: pointer;}
        #search-box{padding: 10px;border: #a8d4b1 1px solid;border-radius:4px;}
    </style>
    <script src="{{ asset('js/froogaloop2.min.js') }}"></script>
    <script src="{{ asset('js/jquery-1.11.3.min.js') }}"></script>    
    <script src="{{ asset('js/jquery-migrate.min.js') }}"></script>
    <script src="{{ asset('js/modernizr-2.6.2.min.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.min.js') }}"></script>
    @yield('scripts')
</head>
<body class="home-galery-posts" data-gr-c-s-loaded="true">
    @yield('body')
    <div id="sidebar" class="sidebar sidebar-visible-pro">
        <div id="sidebar-padding" style="z-index: 1000; position: fixed; top: 0px; margin-left: 0px; width: 230px; left: 0px;" class="scroll-to-fixed-fixed">
            <div class="tablet-show-hide"><i class="fa fa-bars"></i></div>
            <header>
                @if (Auth::check())
                <style type="text/css">
                    .avatar {
                        border-radius: 50%;
                        -moz-border-radius: 50%;
                        -webkit-border-radius: 50%;
                    }

                </style>
                <div align="center">
                    <img src="{{ Auth::user()->getAvatar() }}" alt="{{ Auth::user()->getName() }}" class="avatar">
                </div>
                @else
                <h1 id="logo">
                    <a href="{{ url('/') }}" title="{{ config('app.name', 'Laravel') }}" rel="home">
                        <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name', 'Laravel') }}" width="170"/>
                    </a>
                </h1>
                @endif
                <nav>
                    <div class="menu-main-navigation-container">
                        <ul id="menu-main-navigation" class="sf-menu sf-vertical sf-js-enabled">
                            <li class="menu-item">
                                <a href="{{ url('/') }}">Home</a>
                            </li>
                            <li class="menu-item">
                                <a href="{{url('/catalogue')}}" class="sf-with-ul">Catalogue<span class="sf-sub-indicator"><i class="fa fa-angle-down"></i></span></a>
                                @php
                                $categories = App\Models\Category::get();
                                @endphp
                                <ul class="sub-menu" style="display: none; float: none; width: 11.5em; visibility: hidden;">
                                    @foreach($categories as $category)
                                    <li class="menu-item" style="white-space: normal; float: none; width: 100%;">
                                        <a href="{{ route('catalogue', $category->slug) }}" style="float: none; width: auto;">{{ $category->name }}</a>
                                    </li>
                                    @endforeach
                                </ul>
                            </li>
                            @if (Auth::check())
                            <li class="menu-item">
                                <a href="{{url('/bookmarks')}}">Bookmarks</a>
                            </li>
                            @endif
                            <li class="menu-item">
                                @if (Auth::check())
                                    <a href="{{url('/account')}}">Profile</a>
                                @else
                                    <a href="#" class="disabled">Profile</a>
                                @endif
                            </li>
                            <li class="menu-item">
                                <a href="{{url('/submit')}}">Submit Style</a>
                            </li>
                            <!-- <li class="menu-item">
                                <a href="{{url('/contact')}}">Contact</a>
                            </li> -->
                        </ul>
                        <select class="select-menu">
                            <option value="#">Navigate to...</option>
                            <option value="{{ url('/') }}" selected="selected">&nbsp;Home</option>
                            <option value="{{ url('/catalogue') }}">&nbsp;Catalogue</option>
                            @foreach($categories as $category)
                                <option value="{{ route('catalogue', $category->slug) }}">––&nbsp;{{ $category->name }}</option>
                            @endforeach
                            <option value="{{url('/account')}}">&nbsp;Profile</option>
                            <option value="{{url('/send')}}">&nbsp;Send Style</option>
                        </select>
                    </div>
                </nav>
                <div class="clearfix"></div>
            </header>
            
            <div id="navigation-sidebar-pro">   
                <div id="pyre_social_media-widget-feat-2" class="sidebar-item widget pyre_social_media-feat">
                    <div class="social-icons-widget-pro">
                        <ul class="social-ico">
                            <li>
                                <a href="https://www.facebook.com/shakaradotng" target="_blank">
                                    <i class="fa fa-facebook"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://twitter.com/shakaradotng" target="_blank">
                                    <i class="fa fa-twitter"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://www.instagram.com/shakaradotng" target="_blank">
                                    <i class="fa fa-instagram"></i>
                                </a>
                            </li>
                            <li>
                                <a href="mailto:support@shakara.ng" target="_blank">
                                    <i class="fa fa-envelope"></i>
                                </a>
                            </li>
                        </ul><!-- close .social-ico -->
                    </div><!-- close .social-icons-widget-pro -->
                </div>
                <div class="sidebar-divider"></div>
            </div>
            <div>
                @if (Auth::check())
                    <a href="{{ route('logout') }}">Logout</a>
                @else
                    <a href="{{ url('/login') }}">Login or Register</a>
                @endif
            </div>      
            <div class="clearfix"></div>
        </div>
        <div class="pro-spacer" style="display: block; width: 270px; height: 573px; float: none;"></div><!-- close #sidebar-padding -->
        <div class="clearfix"></div>
    </div><!-- close #sidebar -->
    <div class="show-hide-pro sidebar-show-hide"><i class="fa fa-bars"></i></div><!-- Show/Hide Sidebar Button -->
    <div class="show-hide-pro"><i class="fa fa-bars"></i></div><!-- Show/Hide Sidebar Button -->
    <div id="toggle-cover-pro"></div><!-- black screen covering on sidebar extend -->

    <style type="text/css">
        
    </style>
    
    <div id="search-div">
        <div id='search-box' class="sf-with-ul" style="margin-right: 20px; margin-left: 20px">
            <form class="search_bar larger" action='{{ url("/search")}}' id='search-form' method='get' target='_top'>
                {{ csrf_field() }}
                <div class="search_dropdown" style="width: 19px;">
                    <select name="cat">
                        <option selected value="0">All</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <input id='search-box' name='q' type="text" placeholder="Search for anything" style="width: 84.1193%; margin-left: 75px;">
                <div id="search-suggesstion-box"></div>
                <button type="submit" value="Search">Search</button>
            </form>
        </div>
    </div>

    @yield('content')

    <div class="clearfix"></div>

    <footer>
        <div class="footer-3-column">
            <div class="clearfix"></div>
        </div>
        <div id="copyright">
            &copy; <script>document.write(new Date().getFullYear())</script>, All Rights Reserved.
            <div class="clearfix"></div>
        </div><!-- close #copyright -->
    </footer>

    <!-- Scripts -->
    <script src="{{ asset('js/plugins.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('js/typeahead.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            $("#search-box").keyup(function(){
                $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('search-suggestion') }}",
                data:'query='+$(this).val(),
                beforeSend: function(){
                    $("#search-box").css("background","#FFF url(images/LoaderIcon.gif) no-repeat 165px");
                },
                success: function(data){
                    $("#search-suggesstion-box").show();
                    $("#search-suggesstion-box").html(data.value);
                    $("#search-box").css("background","#FFF");
                }
                });
            });
        });

        function selectSearch(val) {
            $("#search-box").val(val);
            $("#search-suggesstion-box").hide();
        }
    </script>
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-104789000-1', 'auto');
      ga('send', 'pageview');

    </script>
</body>
</html>
