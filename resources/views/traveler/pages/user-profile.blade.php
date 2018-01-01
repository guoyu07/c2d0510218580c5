<!DOCTYPE HTML>
<html>


<!-- Mirrored from remtsoy.com/tf_templates/traveler/demo_v1_7/user-profile.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 11 Aug 2017 21:57:25 GMT -->
<head>
    <title>Traveler - Travel Profile</title>


    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta name="keywords" content="Template, html, premium, themeforest" />
    <meta name="description" content="Traveler - Premium template for travel companies">
    <meta name="author" content="Tsoy">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- GOOGLE FONTS -->
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,300,600' rel='stylesheet' type='text/css'>
    <!-- /GOOGLE FONTS -->
    <link rel="stylesheet" href="{{ url('traveler') }}/css/bootstrap.css">
    <link rel="stylesheet" href="{{ url('traveler') }}/css/font-awesome.css">
    <link rel="stylesheet" href="{{ url('traveler') }}/css/icomoon.css">
    <link rel="stylesheet" href="{{ url('traveler') }}/css/styles.css">
    <link rel="stylesheet" href="{{ url('traveler') }}/css/mystyles.css">
    <script src="{{ url('traveler') }}/js/modernizr.js"></script>

    <link rel="stylesheet" href="{{ url('traveler') }}/css/switcher.css" />
    <link rel="alternate stylesheet" type="text/css" href="{{ url('traveler') }}/css/schemes/bright-turquoise.css" title="bright-turquoise" media="all" />
    <link rel="alternate stylesheet" type="text/css" href="{{ url('traveler') }}/css/schemes/turkish-rose.css" title="turkish-rose" media="all" />
    <link rel="alternate stylesheet" type="text/css" href="{{ url('traveler') }}/css/schemes/salem.css" title="salem" media="all" />
    <link rel="alternate stylesheet" type="text/css" href="{{ url('traveler') }}/css/schemes/hippie-blue.css" title="hippie-blue" media="all" />
    <link rel="alternate stylesheet" type="text/css" href="{{ url('traveler') }}/css/schemes/mandy.css" title="mandy" media="all" />
    <link rel="alternate stylesheet" type="text/css" href="{{ url('traveler') }}/css/schemes/green-smoke.css" title="green-smoke" media="all" />
    <link rel="alternate stylesheet" type="text/css" href="{{ url('traveler') }}/css/schemes/horizon.css" title="horizon" media="all" />
    <link rel="alternate stylesheet" type="text/css" href="{{ url('traveler') }}/css/schemes/cerise.css" title="cerise" media="all" />
    <link rel="alternate stylesheet" type="text/css" href="{{ url('traveler') }}/css/schemes/brick-red.css" title="brick-red" media="all" />
    <link rel="alternate stylesheet" type="text/css" href="{{ url('traveler') }}/css/schemes/de-york.css" title="de-york" media="all" />
    <link rel="alternate stylesheet" type="text/css" href="{{ url('traveler') }}/css/schemes/shamrock.css" title="shamrock" media="all" />
    <link rel="alternate stylesheet" type="text/css" href="{{ url('traveler') }}/css/schemes/studio.css" title="studio" media="all" />
    <link rel="alternate stylesheet" type="text/css" href="{{ url('traveler') }}/css/schemes/leather.css" title="leather" media="all" />
    <link rel="alternate stylesheet" type="text/css" href="{{ url('traveler') }}/css/schemes/denim.css" title="denim" media="all" />
    <link rel="alternate stylesheet" type="text/css" href="{{ url('traveler') }}/css/schemes/scarlet.css" title="scarlet" media="all" />
</head>

<body>

    <!-- FACEBOOK WIDGET -->
    <div id="fb-root"></div>
    <script>
        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.0";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
    <!-- /FACEBOOK WIDGET -->
    <div class="global-wrap">
        <div class="demo_changer" id="demo_changer">
            <div class="demo-icon fa fa-sliders"></div>
            <div class="form_holder">
                <div class="line"></div>
                <p>Color Scheme</p>
                <div class="predefined_styles" id="styleswitch_area">
                    <a class="styleswitch" href="{{ url('traveler') }}/user-profilec392.html?default=true" style="background:#ED8323;"></a>
                    <a class="styleswitch" href="{{ url('traveler') }}/#" data-src="{{ url('traveler') }}/bright-turquoise" style="background:#0EBCF2;"></a>
                    <a class="styleswitch" href="{{ url('traveler') }}/#" data-src="{{ url('traveler') }}/turkish-rose" style="background:#B66672;"></a>
                    <a class="styleswitch" href="{{ url('traveler') }}/#" data-src="{{ url('traveler') }}/salem" style="background:#12A641;"></a>
                    <a class="styleswitch" href="{{ url('traveler') }}/#" data-src="{{ url('traveler') }}/hippie-blue" style="background:#4F96B6;"></a>
                    <a class="styleswitch" href="{{ url('traveler') }}/#" data-src="{{ url('traveler') }}/mandy" style="background:#E45E66;"></a>
                    <a class="styleswitch" href="{{ url('traveler') }}/#" data-src="{{ url('traveler') }}/green-smoke" style="background:#96AA66;"></a>
                    <a class="styleswitch" href="{{ url('traveler') }}/#" data-src="{{ url('traveler') }}/horizon" style="background:#5B84AA;"></a>
                    <a class="styleswitch" href="{{ url('traveler') }}/#" data-src="{{ url('traveler') }}/cerise" style="background:#CA2AC6;"></a>
                    <a class="styleswitch" href="{{ url('traveler') }}/#" data-src="{{ url('traveler') }}/brick-red" style="background:#cf315a;"></a>
                    <a class="styleswitch" href="{{ url('traveler') }}/#" data-src="{{ url('traveler') }}/de-york" style="background:#74C683;"></a>
                    <a class="styleswitch" href="{{ url('traveler') }}/#" data-src="{{ url('traveler') }}/shamrock" style="background:#30BBB1;"></a>
                    <a class="styleswitch" href="{{ url('traveler') }}/#" data-src="{{ url('traveler') }}/studio" style="background:#7646B8;"></a>
                    <a class="styleswitch" href="{{ url('traveler') }}/#" data-src="{{ url('traveler') }}/leather" style="background:#966650;"></a>
                    <a class="styleswitch" href="{{ url('traveler') }}/#" data-src="{{ url('traveler') }}/denim" style="background:#1A5AE4;"></a>
                    <a class="styleswitch" href="{{ url('traveler') }}/#" data-src="{{ url('traveler') }}/scarlet" style="background:#FF1D13;"></a>
                </div>
                <div class="line"></div>
                <p>Layout</p>
                <div class="predefined_styles"><a class="btn btn-sm" href="{{ url('traveler') }}/#" id="btn-wide">Wide</a><a class="btn btn-sm" href="{{ url('traveler') }}/#" id="btn-boxed">Boxed</a>
                </div>
                <div class="line"></div>
                <p>Background Patterns</p>
                <div class="predefined_styles" id="patternswitch_area">
                    <a class="patternswitch" href="{{ url('traveler') }}/#" style="background-image: url(img/patterns/binding_light.png);"></a>
                    <a class="patternswitch" href="{{ url('traveler') }}/#" style="background-image: url(img/patterns/binding_dark.png);"></a>
                    <a class="patternswitch" href="{{ url('traveler') }}/#" style="background-image: url(img/patterns/dark_fish_skin.png);"></a>
                    <a class="patternswitch" href="{{ url('traveler') }}/#" style="background-image: url(img/patterns/dimension.png);"></a>
                    <a class="patternswitch" href="{{ url('traveler') }}/#" style="background-image: url(img/patterns/escheresque_ste.png);"></a>
                    <a class="patternswitch" href="{{ url('traveler') }}/#" style="background-image: url(img/patterns/food.png);"></a>
                    <a class="patternswitch" href="{{ url('traveler') }}/#" style="background-image: url(img/patterns/giftly.png);"></a>
                    <a class="patternswitch" href="{{ url('traveler') }}/#" style="background-image: url(img/patterns/grey_wash_wall.png);"></a>
                    <a class="patternswitch" href="{{ url('traveler') }}/#" style="background-image: url(img/patterns/ps_neutral.png);"></a>
                    <a class="patternswitch" href="{{ url('traveler') }}/#" style="background-image: url(img/patterns/pw_maze_black.png);"></a>
                    <a class="patternswitch" href="{{ url('traveler') }}/#" style="background-image: url(img/patterns/pw_pattern.png);"></a>
                    <a class="patternswitch" href="{{ url('traveler') }}/#" style="background-image: url(img/patterns/simple_dashed.png);"></a>
                </div>
                <div class="line"></div>
                <p>Background Images</p>
                <div class="predefined_styles" id="bgimageswitch_area">
                    <a class="bgimageswitch" href="{{ url('traveler') }}/#" style="background-image: url(img/switcher/bike.jpg);" data-src="{{ url('traveler') }}/img/backgrounds/bike.jpg"></a>
                    <a class="bgimageswitch" href="{{ url('traveler') }}/#" style="background-image: url(img/switcher/flowers.jpg);" data-src="{{ url('traveler') }}/img/backgrounds/flowers.jpg"></a>
                    <a class="bgimageswitch" href="{{ url('traveler') }}/#" style="background-image: url(img/switcher/wood.jpg);" data-src="{{ url('traveler') }}/img/backgrounds/wood.jpg"></a>
                    <a class="bgimageswitch" href="{{ url('traveler') }}/#" style="background-image: url(img/switcher/taxi.jpg);" data-src="{{ url('traveler') }}/img/backgrounds/taxi.jpg"></a>
                    <a class="bgimageswitch" href="{{ url('traveler') }}/#" style="background-image: url(img/switcher/phone.jpg);" data-src="{{ url('traveler') }}/img/backgrounds/phone.jpg"></a>
                    <a class="bgimageswitch" href="{{ url('traveler') }}/#" style="background-image: url(img/switcher/road.jpg);" data-src="{{ url('traveler') }}/img/backgrounds/road.jpg"></a>
                    <a class="bgimageswitch" href="{{ url('traveler') }}/#" style="background-image: url(img/switcher/keyboard.jpg);" data-src="{{ url('traveler') }}/img/backgrounds/keyboard.jpg"></a>
                    <a class="bgimageswitch" href="{{ url('traveler') }}/#" style="background-image: url(img/switcher/beach.jpg);" data-src="{{ url('traveler') }}/img/backgrounds/beach.jpg"></a>
                    <a class="bgimageswitch" href="{{ url('traveler') }}/#" style="background-image: url(img/switcher/street.jpg);" data-src="{{ url('traveler') }}/img/backgrounds/street.jpg"></a>
                    <a class="bgimageswitch" href="{{ url('traveler') }}/#" style="background-image: url(img/switcher/nature.jpg);" data-src="{{ url('traveler') }}/img/backgrounds/nature.jpg"></a>
                    <a class="bgimageswitch" href="{{ url('traveler') }}/#" style="background-image: url(img/switcher/bridge.jpg);" data-src="{{ url('traveler') }}/img/backgrounds/bridge.jpg"></a>
                    <a class="bgimageswitch" href="{{ url('traveler') }}/#" style="background-image: url(img/switcher/cameras.jpg);" data-src="{{ url('traveler') }}/img/backgrounds/cameras.jpg"></a>
                </div>
                <div class="line"></div>
            </div>
        </div>
        <header id="main-header">
            <div class="header-top">
                <div class="container">
                    <div class="row">
                        <div class="col-md-3">
                            <a class="logo" href="{{ url('traveler') }}/index-2.html">
                                <img src="{{ url('traveler') }}/img/logo-invert.png" alt="Image Alternative text" title="Image Title" />
                            </a>
                        </div>
                        <div class="col-md-3 col-md-offset-2">
                            <form class="main-header-search">
                                <div class="form-group form-group-icon-left">
                                    <i class="fa fa-search input-icon"></i>
                                    <input type="text" class="form-control">
                                </div>
                            </form>
                        </div>
                        <div class="col-md-4">
                            <div class="top-user-area clearfix">
                                <ul class="top-user-area-list list list-horizontal list-border">
                                    <li class="top-user-area-avatar">
                                        <a href="{{ url('traveler') }}/user-profile.html">
                                            <img class="origin round" src="{{ url('traveler') }}/img/amaze_40x40.jpg" alt="Image Alternative text" title="AMaze" />Hi, John</a>
                                    </li>
                                    <li><a href="{{ url('traveler') }}/#">Sign Out</a>
                                    </li>
                                    <li class="nav-drop"><a href="{{ url('traveler') }}/#">USD $<i class="fa fa-angle-down"></i><i class="fa fa-angle-up"></i></a>
                                        <ul class="list nav-drop-menu">
                                            <li><a href="{{ url('traveler') }}/#">EUR<span class="right">€</span></a>
                                            </li>
                                            <li><a href="{{ url('traveler') }}/#">GBP<span class="right">£</span></a>
                                            </li>
                                            <li><a href="{{ url('traveler') }}/#">JPY<span class="right">円</span></a>
                                            </li>
                                            <li><a href="{{ url('traveler') }}/#">CAD<span class="right">$</span></a>
                                            </li>
                                            <li><a href="{{ url('traveler') }}/#">AUD<span class="right">A$</span></a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="top-user-area-lang nav-drop">
                                        <a href="{{ url('traveler') }}/#">
                                            <img src="{{ url('traveler') }}/img/flags/32/uk.png" alt="Image Alternative text" title="Image Title" />ENG<i class="fa fa-angle-down"></i><i class="fa fa-angle-up"></i>
                                        </a>
                                        <ul class="list nav-drop-menu">
                                            <li>
                                                <a title="German" href="{{ url('traveler') }}/#">
                                                    <img src="{{ url('traveler') }}/img/flags/32/de.png" alt="Image Alternative text" title="Image Title" /><span class="right">GER</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a title="Japanise" href="{{ url('traveler') }}/#">
                                                    <img src="{{ url('traveler') }}/img/flags/32/jp.png" alt="Image Alternative text" title="Image Title" /><span class="right">JAP</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a title="Italian" href="{{ url('traveler') }}/#">
                                                    <img src="{{ url('traveler') }}/img/flags/32/it.png" alt="Image Alternative text" title="Image Title" /><span class="right">ITA</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a title="French" href="{{ url('traveler') }}/#">
                                                    <img src="{{ url('traveler') }}/img/flags/32/fr.png" alt="Image Alternative text" title="Image Title" /><span class="right">FRE</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a title="Russian" href="{{ url('traveler') }}/#">
                                                    <img src="{{ url('traveler') }}/img/flags/32/ru.png" alt="Image Alternative text" title="Image Title" /><span class="right">RUS</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a title="Korean" href="{{ url('traveler') }}/#">
                                                    <img src="{{ url('traveler') }}/img/flags/32/kr.png" alt="Image Alternative text" title="Image Title" /><span class="right">KOR</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="nav">
                    <ul class="slimmenu" id="slimmenu">
                        <li><a href="{{ url('traveler') }}/index-2.html">Home</a>
                            <ul>
                                <li><a href="{{ url('traveler') }}/index-2.html">Default</a>
                                </li>
                                <li><a href="{{ url('traveler') }}/index-1.html">Layout 1</a>
                                </li>
                                <li><a href="{{ url('traveler') }}/index-3.html">Layout 2</a>
                                </li>
                                <li><a href="{{ url('traveler') }}/index-4.html">Layout 3</a>
                                </li>
                                <li><a href="{{ url('traveler') }}/index-5.html">Layout 4</a>
                                </li>
                                <li><a href="{{ url('traveler') }}/index-6.html">Layout 5</a>
                                </li>
                                <li><a href="{{ url('traveler') }}/index-7.html">Layout 6</a>
                                </li>
                                <li><a href="{{ url('traveler') }}/index-8.html">Layout 7</a>
                                </li>
                            </ul>
                        </li>
                        <li class="active"><a href="{{ url('traveler') }}/success-payment.html">Pages</a>
                            <ul>
                                <li><a href="{{ url('traveler') }}/success-payment.html">Success Payment</a>
                                </li>
                                <li class="active"><a href="{{ url('traveler') }}/user-profile.html">User Profile</a>
                                    <ul>
                                        <li class="active"><a href="{{ url('traveler') }}/user-profile.html">Overview</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/user-profile-settings.html">Settings</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/user-profile-photos.html">Photos</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/user-profile-booking-history.html">Booking History</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/user-profile-cards.html">Cards</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/user-profile-wishlist.html">Wishlist</a>
                                        </li>
                                    </ul>
                                </li>
                                <li><a href="{{ url('traveler') }}/blog.html">Blog</a>
                                    <ul>
                                        <li><a href="{{ url('traveler') }}/blog.html">Sidebar Right</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/blog-sidebar-left.html">Sidebar Left</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/blog-full-width.html">Full Width</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/blog-post.html">Post</a>
                                            <ul>
                                                <li><a href="{{ url('traveler') }}/blog-post.html">Sidebar Right</a>
                                                </li>
                                                <li><a href="{{ url('traveler') }}/blog-post-sidebar-left.html">Sidebar Left</a>
                                                </li>
                                                <li><a href="{{ url('traveler') }}/blog-post-full-width.html">Full Width</a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <li><a href="{{ url('traveler') }}/404.html">404 page</a>
                                </li>
                                <li><a href="{{ url('traveler') }}/contact-us.html">Contact Us</a>
                                </li>
                                <li><a href="{{ url('traveler') }}/about.html">About</a>
                                </li>
                                <li><a href="{{ url('traveler') }}/login-register.html">Login/Register</a>
                                    <ul>
                                        <li><a href="{{ url('traveler') }}/login-register.html">Full Page</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/login-register-normal.html">Normal</a>
                                        </li>
                                    </ul>
                                </li>
                                <li><a href="{{ url('traveler') }}/loading.html">Loading</a>
                                </li>
                                <li><a href="{{ url('traveler') }}/comming-soon.html">Comming Soon</a>
                                </li>
                                <li><a href="{{ url('traveler') }}/gallery.html">Gallery</a>
                                    <ul>
                                        <li><a href="{{ url('traveler') }}/gallery.html">4 Columns</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/gallery-3-col.html">3 columns</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/gallery-2-col.html">2 columns</a>
                                        </li>
                                    </ul>
                                </li>
                                <li><a href="{{ url('traveler') }}/page-full-width.html">Full Width</a>
                                </li>
                                <li><a href="{{ url('traveler') }}/page-sidebar-right.html">Sidebar Right</a>
                                </li>
                                <li><a href="{{ url('traveler') }}/page-sidebar-left.html">Sidebar Left</a>
                                </li>
                            </ul>
                        </li>
                        <li><a href="{{ url('traveler') }}/feature-typography.html">Features</a>
                            <ul>
                                <li><a href="{{ url('traveler') }}/feature-typography.html">Typography</a>
                                </li>
                                <li><a href="{{ url('traveler') }}/feature-icons.html">Icons</a>
                                </li>
                                <li><a href="{{ url('traveler') }}/feature-forms.html">Forms</a>
                                </li>
                                <li><a href="{{ url('traveler') }}/feature-icon-effects.html">Icon Effects</a>
                                </li>
                                <li><a href="{{ url('traveler') }}/feature-elements.html">Elements</a>
                                </li>
                                <li><a href="{{ url('traveler') }}/feature-grid.html">Grid</a>
                                </li>
                                <li><a href="{{ url('traveler') }}/feature-hovers.html">Hover effects</a>
                                </li>
                                <li><a href="{{ url('traveler') }}/feature-lightbox.html">Lightbox</a>
                                </li>
                                <li><a href="{{ url('traveler') }}/feature-media.html">Media</a>
                                </li>
                            </ul>
                        </li>
                        <li><a href="{{ url('traveler') }}/hotels.html">Hotels</a>
                            <ul>
                                <li><a href="{{ url('traveler') }}/hotel-details.html">Details</a>
                                    <ul>
                                        <li><a href="{{ url('traveler') }}/hotel-details.html">Layout 1</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/hotel-details-2.html">Layout 2</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/hotel-details-3.html">Layout 3</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/hotel-details-4.html">Layout 4</a>
                                        </li>
                                    </ul>
                                </li>
                                <li><a href="{{ url('traveler') }}/hotel-payment.html">Payment</a>
                                    <ul>
                                        <li><a href="{{ url('traveler') }}/hotel-payment.html">Registered</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/hotel-payment-registered-card.html">Existed Cards</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/hotel-payment-unregistered.html">Unregistered</a>
                                        </li>
                                    </ul>
                                </li>
                                <li><a href="{{ url('traveler') }}/hotel-search.html">Search</a>
                                    <ul>
                                        <li><a href="{{ url('traveler') }}/hotel-search.html">Layout 1</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/hotel-search-2.html">Layout 2</a>
                                        </li>
                                    </ul>
                                </li>
                                <li><a href="{{ url('traveler') }}/hotels.html">Results</a>
                                    <ul>
                                        <li><a href="{{ url('traveler') }}/hotels.html">Layout 1</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/hotels-search-results-2.html">Layout 2</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/hotels-search-results-3.html">Layout 3</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/hotels-search-results-4.html">Layout 4</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/hotel-search-results-5.html">Layout 5</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li><a href="{{ url('traveler') }}/flights.html">Flights</a>
                            <ul>
                                <li><a href="{{ url('traveler') }}/flight-payment.html">Payment</a>
                                    <ul>
                                        <li><a href="{{ url('traveler') }}/flight-payment.html">Registered</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/flight-payment-registered-card.html">Existed Cards</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/flight-payment-unregistered.html">Unregistered</a>
                                        </li>
                                    </ul>
                                </li>
                                <li><a href="{{ url('traveler') }}/flight-search.html">Search</a>
                                    <ul>
                                        <li><a href="{{ url('traveler') }}/flight-search.html">Layout 1</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/flight-search-2.html">Layout 2</a>
                                        </li>
                                    </ul>
                                </li>
                                <li><a href="{{ url('traveler') }}/flights.html">List</a>
                                    <ul>
                                        <li><a href="{{ url('traveler') }}/flights.html">Layout 1</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/flights-search-results-2.html">Layout 2</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/flights-search-results-3.html">Layout 3</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/flights-search-results-4.html">Layout 4</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li><a href="{{ url('traveler') }}/rentals.html">Rentals</a>
                            <ul>
                                <li><a href="{{ url('traveler') }}/rentals-details.html">Details</a>
                                    <ul>
                                        <li><a href="{{ url('traveler') }}/rentals-details.html">Layout 1</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/rentals-details-2.html">Layout 2</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/rentals-details-3.html">Layout 3</a>
                                        </li>
                                    </ul>
                                </li>
                                <li><a href="{{ url('traveler') }}/rental-payment.html">Payment</a>
                                    <ul>
                                        <li><a href="{{ url('traveler') }}/rental-payment.html">Registered</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/rental-payment-registered-card.html">Existed Cards</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/rental-payment-unregistered.html">Unregistered</a>
                                        </li>
                                    </ul>
                                </li>
                                <li><a href="{{ url('traveler') }}/rentals-search.html">Search</a>
                                    <ul>
                                        <li><a href="{{ url('traveler') }}/rentals-search.html">Layout 1</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/rentals-search-2.html">Layout 2</a>
                                        </li>
                                    </ul>
                                </li>
                                <li><a href="{{ url('traveler') }}/rentals.html">Results</a>
                                    <ul>
                                        <li><a href="{{ url('traveler') }}/rentals.html">Layout 1</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/rentals-search-results-2.html">Layout 2</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/rentals-search-results-3.html">Layout 3</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/rentals-search-results-4.html">Layout 4</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/rentals-search-results-5.html">Layout 5</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li><a href="{{ url('traveler') }}/cars.html">Cars</a>
                            <ul>
                                <li><a href="{{ url('traveler') }}/car-details.html">Details</a>
                                </li>
                                <li><a href="{{ url('traveler') }}/car-payment.html">Payment</a>
                                    <ul>
                                        <li><a href="{{ url('traveler') }}/car-payment.html">Registered</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/car-payment-registered-card.html">Existed Cards</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/car-payment-unregistered.html">Unregistered</a>
                                        </li>
                                    </ul>
                                </li>
                                <li><a href="{{ url('traveler') }}/car-search.html">Search</a>
                                    <ul>
                                        <li><a href="{{ url('traveler') }}/car-search.html">Layout 1</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/car-search-2.html">Layout 2</a>
                                        </li>
                                    </ul>
                                </li>
                                <li><a href="{{ url('traveler') }}/cars.html">Results</a>
                                    <ul>
                                        <li><a href="{{ url('traveler') }}/cars.html">Layout 1</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/cars-results-2.html">Layout 2</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/cars-results-3.html">Layout 3</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/cars-results-4.html">Layout 4</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/cars-results-5.html">Layout 5</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li><a href="{{ url('traveler') }}/activities.html">Activities</a>
                            <ul>
                                <li><a href="{{ url('traveler') }}/activitiy-details.html">Details</a>
                                    <ul>
                                        <li><a href="{{ url('traveler') }}/activitiy-details.html">Layout 1</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/activitiy-details-2.html">Layout 2</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/activitiy-details-3.html">Layout 3</a>
                                        </li>
                                    </ul>
                                </li>
                                <li><a href="{{ url('traveler') }}/activity-search.html">Search</a>
                                    <ul>
                                        <li><a href="{{ url('traveler') }}/activity-search.html">Layout 1</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/activity-search-2.html">Layout 2</a>
                                        </li>
                                    </ul>
                                </li>
                                <li><a href="{{ url('traveler') }}/activitiy-payment.html">Payment</a>
                                    <ul>
                                        <li><a href="{{ url('traveler') }}/activitiy-payment.html">Registered</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/activity-payment-registered-card.html">Existed Cards</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/activitiy-payment-unregistered.html">Unregistered</a>
                                        </li>
                                    </ul>
                                </li>
                                <li><a href="{{ url('traveler') }}/activities.html">Results</a>
                                    <ul>
                                        <li><a href="{{ url('traveler') }}/activities.html">Layout 1</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/activities-search-results-2.html">Layout 2</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/activities-search-results-3.html">Layout 3</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/activities-search-results-4.html">Layout 4</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/activities-search-results-5.html">Layout 5</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <div class="container">
            <h1 class="page-title">Travel Profile</h1>
        </div>




        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <aside class="user-profile-sidebar">
                        <div class="user-profile-avatar text-center">
                            <img src="{{ url('traveler') }}/img/amaze_300x300.jpg" alt="Image Alternative text" title="AMaze" />
                            <h5>John Doe</h5>
                            <p>Member Since May 2012</p>
                        </div>
                        <ul class="list user-profile-nav">
                            <li><a href="{{ url('traveler') }}/user-profile.html"><i class="fa fa-user"></i>Overview</a>
                            </li>
                            <li><a href="{{ url('traveler') }}/user-profile-settings.html"><i class="fa fa-cog"></i>Settings</a>
                            </li>
                            <li><a href="{{ url('traveler') }}/user-profile-photos.html"><i class="fa fa-camera"></i>My Travel Photos</a>
                            </li>
                            <li><a href="{{ url('traveler') }}/user-profile-booking-history.html"><i class="fa fa-clock-o"></i>Booking History</a>
                            </li>
                            <li><a href="{{ url('traveler') }}/user-profile-cards.html"><i class="fa fa-credit-card"></i>Credit/Debit Cards</a>
                            </li>
                            <li><a href="{{ url('traveler') }}/user-profile-wishlist.html"><i class="fa fa-heart-o"></i>Wishlist</a>
                            </li>
                        </ul>
                    </aside>
                </div>
                <div class="col-md-9">
                    <h4>Total Traveled</h4>
                    <ul class="list list-inline user-profile-statictics mb30">
                        <li><i class="fa fa-dashboard user-profile-statictics-icon"></i>
                            <h5>12540</h5>
                            <p>Miles</p>
                        </li>
                        <li><i class="fa fa-globe user-profile-statictics-icon"></i>
                            <h5>2%</h5>
                            <p>World</p>
                        </li>
                        <li><i class="fa fa-building-o user-profile-statictics-icon"></i>
                            <h5>15</h5>
                            <p>Cityes</p>
                        </li>
                        <li><i class="fa fa-flag-o user-profile-statictics-icon"></i>
                            <h5>3</h5>
                            <p>Countries</p>
                        </li>
                        <li><i class="fa fa-plane user-profile-statictics-icon"></i>
                            <h5>20</h5>
                            <p>Trips</p>
                        </li>
                    </ul>
                    <div id="map-canvas" style="width:100%; height:400px;"></div>
                </div>
            </div>
        </div>



        <div class="gap"></div>
        <footer id="main-footer">
            <div class="container">
                <div class="row row-wrap">
                    <div class="col-md-3">
                        <a class="logo" href="{{ url('traveler') }}/index-2.html">
                            <img src="{{ url('traveler') }}/img/logo-invert.png" alt="Image Alternative text" title="Image Title" />
                        </a>
                        <p class="mb20">Booking, reviews and advices on hotels, resorts, flights, vacation rentals, travel packages, and lots more!</p>
                        <ul class="list list-horizontal list-space">
                            <li>
                                <a class="fa fa-facebook box-icon-normal round animate-icon-bottom-to-top" href="{{ url('traveler') }}/#"></a>
                            </li>
                            <li>
                                <a class="fa fa-twitter box-icon-normal round animate-icon-bottom-to-top" href="{{ url('traveler') }}/#"></a>
                            </li>
                            <li>
                                <a class="fa fa-google-plus box-icon-normal round animate-icon-bottom-to-top" href="{{ url('traveler') }}/#"></a>
                            </li>
                            <li>
                                <a class="fa fa-linkedin box-icon-normal round animate-icon-bottom-to-top" href="{{ url('traveler') }}/#"></a>
                            </li>
                            <li>
                                <a class="fa fa-pinterest box-icon-normal round animate-icon-bottom-to-top" href="{{ url('traveler') }}/#"></a>
                            </li>
                        </ul>
                    </div>

                    <div class="col-md-3">
                        <h4>Newsletter</h4>
                        <form>
                            <label>Enter your E-mail Address</label>
                            <input type="text" class="form-control">
                            <p class="mt5"><small>*We Never Send Spam</small>
                            </p>
                            <input type="submit" class="btn btn-primary" value="Subscribe">
                        </form>
                    </div>
                    <div class="col-md-2">
                        <ul class="list list-footer">
                            <li><a href="{{ url('traveler') }}/#">About US</a>
                            </li>
                            <li><a href="{{ url('traveler') }}/#">Press Centre</a>
                            </li>
                            <li><a href="{{ url('traveler') }}/#">Best Price Guarantee</a>
                            </li>
                            <li><a href="{{ url('traveler') }}/#">Travel News</a>
                            </li>
                            <li><a href="{{ url('traveler') }}/#">Jobs</a>
                            </li>
                            <li><a href="{{ url('traveler') }}/#">Privacy Policy</a>
                            </li>
                            <li><a href="{{ url('traveler') }}/#">Terms of Use</a>
                            </li>
                            <li><a href="{{ url('traveler') }}/#">Feedback</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <h4>Have Questions?</h4>
                        <h4 class="text-color">+91-11-45611178</h4>
                        <h4><a href="{{ url('traveler') }}/#" class="text-color">support@flygoldfinch.com</a></h4>
                        <p>24/7 Dedicated Customer Support</p>
                    </div>

                </div>
            </div>
        </footer>

        <script src="{{ url('traveler') }}/js/jquery.js"></script>
        <script src="{{ url('traveler') }}/js/bootstrap.js"></script>
        <script src="{{ url('traveler') }}/js/slimmenu.js"></script>
        <script src="{{ url('traveler') }}/js/bootstrap-datepicker.js"></script>
        <script src="{{ url('traveler') }}/js/bootstrap-timepicker.js"></script>
        <script src="{{ url('traveler') }}/js/nicescroll.js"></script>
        <script src="{{ url('traveler') }}/js/dropit.js"></script>
        <script src="{{ url('traveler') }}/js/ionrangeslider.js"></script>
        <script src="{{ url('traveler') }}/js/icheck.js"></script>
        <script src="{{ url('traveler') }}/js/fotorama.js"></script>
        <script src="{{ url('traveler') }}/https://maps.googleapis.com/maps/api/js?v=3.exp&amp;sensor=false"></script>
        <script src="{{ url('traveler') }}/js/typeahead.js"></script>
        <script src="{{ url('traveler') }}/js/card-payment.js"></script>
        <script src="{{ url('traveler') }}/js/magnific.js"></script>
        <script src="{{ url('traveler') }}/js/owl-carousel.js"></script>
        <script src="{{ url('traveler') }}/js/fitvids.js"></script>
        <script src="{{ url('traveler') }}/js/tweet.js"></script>
        <script src="{{ url('traveler') }}/js/countdown.js"></script>
        <script src="{{ url('traveler') }}/js/gridrotator.js"></script>
        <script src="{{ url('traveler') }}/js/custom.js"></script>
        <script src="{{ url('traveler') }}/js/switcher.js"></script>
    </div>
</body>


<!-- Mirrored from remtsoy.com/tf_templates/traveler/demo_v1_7/user-profile.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 11 Aug 2017 21:57:25 GMT -->
</html>



