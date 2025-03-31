<!doctype html>

<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->

<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->

<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->

<!--[if gt IE 8]><!-->

<html class="no-js" lang=""> <!--<![endif]-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Huduki Jobs</title>

    <meta name="description" content="Admin">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta http-equiv="Pragma" content="no-cache">

    <meta http-equiv="no-cache">

    <meta http-equiv="Expires" content="-1">

    <meta http-equiv="Cache-Control" content="no-cache">

    <link rel="icon" href="{{ asset('templates-assets/myadminweb/images/logo.png') }}" type="image/jpg">



    <link rel="apple-touch-icon" href="apple-icon.png">

    <link rel="shortcut icon" href="favicon.ico">



    <link rel="stylesheet" href="{{ asset('templates-assets/myadminweb/css/bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ asset('templates-assets/myadminweb/css/font-awesome.min.css') }}">

    <link rel="stylesheet" href="{{ asset('templates-assets/myadminweb/css/main.css') }}">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet'>

    <!-- Data tables  -->

    <link rel="stylesheet" href="{{ asset('templates-assets/myadminweb/css/dataTables.bootstrap.min.css') }}">

    <script src="{{ asset('templates-assets/myadminweb/js/jquery-2.1.4.min.js') }}"></script>

    <script src="{{ asset('templates-assets/myadminweb/js/jquery_ajax_1.1.js') }}"></script>

    <!-- <script src="{{ asset('templates-assets/myadminweb/js/bootstrap.min.js') }}"></script> -->

</head>


<body>
    <!-- Left Panel -->

    <aside id="left-panel" class="left-panel ">

        <nav class="navbar navbar-expand-sm navbar-default"
            style="background-color: steelblue !important;border: steelblue !important;">

            <div class="navbar-header">

                <button class="navbar-toggler navbtn_responsiv" type="button" data-toggle="collapse"
                    data-target="#main-menu" aria-controls="main-menu" aria-expanded="false"
                    aria-label="Toggle navigation">

                    <i class="fa fa-bars"></i>

                </button>

                <a class="navbar-brand" href="#">Huduki Jobs


                    <!--<img src="{{ asset('templates-assets/myadminweb/images/homelogo.png') }}" alt="Logo">-->

                </a>

                <a class="navbar-brand hidden" href="./">

                    <!--<img src="{{ asset('templates-assets/myadminweb/images/homelogo.png') }}" alt="Logo">-->

                </a>

            </div>



            <div id="main-menu" class="main-menu collapse navbar-collapse">

                <ul class="nav navbar-nav">

                    <li class="active">

                        <a href="{{ url('home') }}"> <i class="menu-icon fa fa-dashboard"></i>Dashboard </a>

                    </li>




                    <li>

                        <a href="{{ url('wholesalers') }}"> <i class="menu-icon fa fa-user"></i>Employer Lists </a>

                    </li>
                    <li>

                        <a href="{{ url('employee') }}"> <i class="menu-icon fa fa-user"></i>Employee Lists </a>

                    </li>

                    <li>

                        <a href="{{ url('training-videos') }}"> <i class="menu-icon fa fa-video-camera"></i>
                            Training Videos</a>

                    </li>

                    <li>

                        <a href="{{ url('subjects') }}"> <i class="menu-icon fa fa-file"></i>
                            Subjects</a>

                    </li>

                    <li>

                        <a href="{{ url('notifications') }}"> <i class="menu-icon fa fa-map-pin"></i>Notifications</a>

                    </li>

                    <li>
                        <a href="{{ url('ecomm-plans') }}"><i class="menu-icon fa fa-list-alt"></i>Subscription
                            Plans</a>
                    </li>
                    <li>
                        <a href="{{ url('purchased-history') }}"><i class="menu-icon fa fa-history"></i>Plan Purchased
                            History</a>
                    </li>


                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false"><i class="menu-icon fa fa-plus-square-o"></i>Dynamic Lists</a>
                        <ul class="sub-menu children dropdown-menu" role="menu">

                            <li>
                                <i class="menu-icon fa fa-plus"></i><a href="{{ url('profession') }}">Job Role List</a>
                            </li>

                            <li>
                                <i class="menu-icon fa fa-plus"></i><a href="{{ url('working') }}">Job Skills List</a>
                            </li>

                            <li>
                                <i class="menu-icon fa fa-plus"></i><a href="{{ url('qualification') }}">Qualifications
                                    List</a>
                            </li>


                            <li>
                                <i class="menu-icon fa fa-plus"></i><a href="{{ url('height') }}">Locations List</a>
                            </li>
                            <li>
                                <i class="menu-icon fa fa-plus"></i><a href="{{ url('advance-skills') }}">Advance
                                    Skills List</a>
                            </li>


                        </ul>
                    </li>
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false"><i class="menu-icon fa fa-plus-square-o"></i>Help Section</a>
                        <ul class="sub-menu children dropdown-menu" role="menu">

                            <li>

                                <a href="{{ url('about') }}"> <i class="menu-icon fa fa-info"></i>About Us</a>

                            </li>

                            <li>

                                <a href="{{ url('term-condition') }}"> <i class="menu-icon fa fa-gavel"></i>Terms &
                                    Conditions</a>

                            </li>

                            <li>

                                <a href="{{ url('privacy-policy') }}"> <i class="menu-icon fa fa-gavel"></i>Privacy
                                    Policy</a>

                            </li>

                            <li>

                                <a href="{{ url('setting') }}"> <i class="menu-icon fa fa-cogs"></i>Settings</a>

                            </li>

                            <li>

                                <a href="{{ url('faq') }}"> <i class="menu-icon fa fa-question"></i>FAQ's</a>

                            </li>


                        </ul>
                    </li>

                </ul>

            </div><!-- /.navbar-collapse -->

        </nav>

    </aside><!-- /#left-panel -->



    <!-- Left Panel -->



    <!-- Right Panel -->



    <div id="right-panel" class="right-panel">

        <!-- Header-->

        <header id="header" class="header">

            <div class="header-menu">

                <!-- <div class="col-sm-7">

                    <a id="menuToggle" class="menutoggle pull-left"><i class="fa fa fa-tasks"></i></a>

                </div> -->



                <div class="col-sm-12 col-md-12 col-lg-12">

                    <!--becoz its not order from-->

                    <div class="col-sm-8">

                        <!--<button type="button" id="eraser" style="float: right;margin-top: 7px;margin-right: 83px;background: darkred;color: white;border-radius: 15%;" onclick="return confirm('Are you sure to erase all data added by Grobiz..?')">Erase Data</button>-->

                    </div>

                    <div class="col-sm-4">
                        <div class="user-area dropdown float-right">




                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">

                                <img class="user-avatar rounded-circle"
                                    src="{{ asset('templates-assets/myadminweb/images/admin.jpg') }}" alt="User">

                            </a>



                            <div class="user-menu dropdown-menu">

                                <a class="nav-link" href="{{ url('profile') }}"><i class="fa fa- user"></i>My
                                    Profile</a>



                                <a class="nav-link" href="{{ url('account') }}"><i
                                        class="fa fa -cog"></i>Account</a>



                                <a class="nav-link" href="{{ url('logout') }}"><i
                                        class="fa fa-power -off"></i>Logout</a>

                            </div>

                        </div>
                    </div>
                </div>

            </div>

        </header><!-- /header -->

        <!-- Header-->



        @yield('content')



    </div>



    <!-- Footer -->



    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"></script>

    <script src="{{ asset('templates-assets/myadminweb/js/plugins.js') }}"></script>



    <!-- Tables   -->

    <script src="{{ asset('templates-assets/myadminweb/js/data-table/datatables.min.js') }}"></script>

    <script src="{{ asset('templates-assets/myadminweb/js/data-table/dataTables.bootstrap.min.js') }}"></script>

    <script src="{{ asset('templates-assets/myadminweb/js/data-table/dataTables.buttons.min.js') }}"></script>

    <script src="{{ asset('templates-assets/myadminweb/js/data-table/buttons.bootstrap.min.js') }}"></script>

    <script src="{{ asset('templates-assets/myadminweb/js/data-table/jszip.min.js') }}"></script>

    <script src="{{ asset('templates-assets/myadminweb/js/data-table/pdfmake.min.js') }}"></script>

    <script src="{{ asset('templates-assets/myadminweb/js/data-table/vfs_fonts.js') }}"></script>

    <script src="{{ asset('templates-assets/myadminweb/js/data-table/buttons.html5.min.js') }}"></script>

    <script src="{{ asset('templates-assets/myadminweb/js/data-table/buttons.print.min.js') }}"></script>

    <script src="{{ asset('templates-assets/myadminweb/js/data-table/buttons.colVis.min.js') }}"></script>

    <script src="{{ asset('templates-assets/myadminweb/js/data-table/datatables-init.js') }}"></script>

    <script src="{{ asset('templates-assets/myadminweb/js/main.js') }}"></script>



    <!-- <script src="{{ asset('templates-assets/myadminweb/js/lib/chart-js/Chart.bundle.js') }}"></script> -->

    <!-- <script src="{{ asset('templates-assets/myadminweb/js/dashboard.js') }}"></script> -->

    <!-- <script src="{{ asset('templates-assets/myadminweb/js/widgets.js') }}"></script> -->

    <!-- <script src="{{ asset('templates-assets/myadminweb/js/lib/vector-map/jquery.vmap.js') }}"></script> -->

    <!-- <script src="{{ asset('templates-assets/myadminweb/js/lib/vector-map/jquery.vmap.min.js') }}"></script> -->

    <!-- <script src="{{ asset('templates-assets/myadminweb/js/lib/vector-map/jquery.vmap.sampledata.js') }}"></script> -->

    <!-- <script src="{{ asset('templates-assets/myadminweb/js/lib/vector-map/country/jquery.vmap.world.js') }}"></script> -->
</body>

</html>
