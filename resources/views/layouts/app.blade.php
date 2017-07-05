<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]> <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>  <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<html lang="{{ app()->getLocale() }}" class=" js flexbox canvas canvastext webgl touch geolocation postmessage websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients cssreflections csstransforms csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers applicationcache svg inlinesvg smil svgclippaths gr__progression-studios_com" lang="en" style="">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
    <link href='http://fonts.googleapis.com/css?family=Fira+Sans:300,400,700,300italic,400italic%7cHind:400,300,700%7cTeko' rel='stylesheet' type='text/css'>
    <link href="{{ asset('css/css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/settings.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/layer.css') }}">
    <script src="{{ asset('js/froogaloop2.min.js') }}"></script>
    <script src="{{ asset('js/jquery-1.11.3.min.js') }}"></script>    
    <script src="{{ asset('js/jquery-migrate.min.js') }}"></script>
    <script src="{{ asset('js/modernizr-2.6.2.min.js') }}"></script>
    <style id="fit-vids-style">.fluid-width-video-wrapper{width:100%;position:relative;padding:0;}.fluid-width-video-wrapper iframe,.fluid-width-video-wrapper object,.fluid-width-video-wrapper embed {position:absolute;top:0;left:0;width:100%;height:100%;}</style>
</head>
<body class="home-galery-posts" data-gr-c-s-loaded="true">
    <div id="sidebar" class="sidebar sidebar-visible-pro">
        <div id="sidebar-padding" style="z-index: 1000; position: fixed; top: 0px; margin-left: 0px; width: 230px; left: 0px;" class="scroll-to-fixed-fixed">
            <div class="tablet-show-hide"><i class="fa fa-bars"></i></div>
            <header>
                <h1 id="logo">
                    @if (Auth::check())
                    <style type="text/css">
                        .img-circular{
                         width: 200px;
                         height: 200px;
                         background-image: url('http://strawberry-fest.org/wp-content/uploads/2012/01/Coca-Cola-logo.jpg');
                         background-size: cover;
                         display: block;
                         border-top-left-radius: 100px;
                         -webkit-border-top-left-radius: 100px;
                         -moz-border-top-left-radius: 100px;
                         border-bottom-right-radius: 100px;
                         -webkit-border-bottom-right-radius: 100px;
                         -moz-border-bottom-right-radius: 100px;
                        }
                    </style>
                    <div class="img-circular"></div>
                    @else
                    <a href="{{ url('/') }}" title="{{ config('app.name', 'Laravel') }}" rel="home">
                        <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name', 'Laravel') }}" width="170">
                    </a>
                    @endif
                </h1>
                <nav>
                    <div class="menu-main-navigation-container">
                        <ul id="menu-main-navigation" class="sf-menu sf-vertical sf-js-enabled">
                            <li class="menu-item">
                                <div id='search-box' class="sf-with-ul">
                                    <form action='/search' id='search-form' method='get' target='_top'>
                                        <input id='search-text' name='q' placeholder='Search' type='text'/>
                                        <button id='search-button' type='submit'>                     
                                            <span><i class="fa fa-search"></i></span>
                                        </button>
                                    </form>
                                </div>
                            </li>
                            @if (Auth::check())
                            <li class="menu-item current-menu-item">
                                <a href="{{ url('/') }}">Recommended</a>
                            </li>
                            @else
                            <li class="menu-item">
                                <a href="{{ url('/') }}">Home</a>
                            </li>
                            @endif
                            <li class="menu-item">
                                <a href="#" class="sf-with-ul">Catalogue<span class="sf-sub-indicator"><i class="fa fa-angle-down"></i></span></a>
                                <ul class="sub-menu" style="display: none; float: none; width: 11.5em; visibility: hidden;">
                                    <li class="menu-item" style="white-space: normal; float: none; width: 100%;">
                                        <a href="#" style="float: none; width: auto;">Men</a>
                                    </li>
                                    <li class="menu-item" style="white-space: normal; float: none; width: 100%;">
                                        <a href="#" style="float: none; width: auto;">Women</a>
                                    </li>
                                    <li class="menu-item" style="white-space: normal; float: none; width: 100%;">
                                        <a href="#" style="float: none; width: auto;">Kids</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="menu-item">
                                <a href="#">About me</a>
                            </li>
                            <li class="menu-item">
                                <a href="#">Journal</a>
                            </li>
                            <li class="menu-item">
                                <a href="#">Contact</a>
                            </li>
                        </ul>
                        <select class="select-menu">
                            <option value="#">Navigate to...</option>
                            <option value="#">&nbsp;Home</option>
                            <option value="#">––&nbsp;Homepage with Gallery</option>
                            <option value="#">––&nbsp;Homepage with Post List</option>
                            <option value="#" selected="selected">––&nbsp;Homepage with Slider &amp; Posts</option>
                            <option value="#">––&nbsp;Homepage with Slider Only</option>
                            <option value="#">&nbsp;Gallery</option>
                            <option value="#">––&nbsp;Default Gallery</option>
                            <option value="#">––&nbsp;Uncropped Gallery</option>
                            <option value="#">––&nbsp;Gallery with Thumbnails</option>
                            <option value="#">––&nbsp;Gallery with Content</option>
                            <option value="#">&nbsp;Portfolio</option>
                            <option value="#">––&nbsp;Fashion</option>
                            <option value="#">––&nbsp;Landscapes</option>
                            <option value="#">––&nbsp;Weddings</option>
                            <option value="#">&nbsp;About me</option>
                            <option value="#">&nbsp;Journal</option>
                            <option value="#">&nbsp;Contact</option>
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
                                <a href="http://facebook.com/oversabistitches" target="_blank">
                                    <i class="fa fa-facebook"></i>
                                </a>
                            </li>
                            <li>
                                <a href="http://twitter.com/oversabi_s" target="_blank">
                                    <i class="fa fa-twitter"></i>
                                </a>
                            </li>
                            <li>
                                <a href="http://pinterest.com/" target="_blank">
                                    <i class="fa fa-pinterest"></i>
                                </a>
                            </li>
                            <li>
                                <a href="mailto:support@oversabi.com.ng" target="_blank">
                                    <i class="fa fa-envelope"></i>
                                </a>
                            </li>
                        </ul><!-- close .social-ico -->
                    </div><!-- close .social-icons-widget-pro -->
                </div>
                <div class="sidebar-divider"></div>
            </div>
            <div>
                @if (!Auth::check())
                    <a href="{{ url('/login') }}">Login</a> | <a href="{{ url('/register') }}">Register</a>
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

    @yield('content')

    <div class="clearfix"></div>

    <footer>
        <div class="footer-3-column">
            <div class="clearfix"></div>
        </div>
        <div id="copyright">
            2017 All Rights Reserved. Developed and Maitained by <a href="http://oversabi.com.ng">Oversabi Stitches</a>.
            <div class="clearfix"></div>
        </div><!-- close #copyright -->
    </footer>

    <!-- Scripts -->
    <script src="{{ asset('js/plugins.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.min.js') }}"></script>

    <!-- RevSlider -->
    <script src="{{ asset('js/revolution-slider.js.download') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.themepunch.tools.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.themepunch.revolution.min.js') }}"></script>

    <!-- SLIDER REVOLUTION 5.0 EXTENSIONS  
        (Load Extensions only on Local File Systems ! 
         The following part can be removed on Server for On Demand Loading) --> 
    <script type="text/javascript" src="{{ asset('js/revolution.extension.actions.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/revolution.extension.carousel.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/revolution.extension.kenburn.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/revolution.extension.layeranimation.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/revolution.extension.migration.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/revolution.extension.navigation.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/revolution.extension.parallax.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/revolution.extension.parallax.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/revolution.extension.parallax.min.js') }}"></script>
</body>
</html>
