<?php
require_once 'Auth.php';
isLogged('login.html');
?>
<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Admin Panel - Telegram Bot</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="assets/images/icon/favicon.ico">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/metisMenu.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/slicknav.min.css">
    <!-- amchart css -->
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
    <!-- others css -->
    <link rel="stylesheet" href="assets/css/typography.css">
    <link rel="stylesheet" href="assets/css/default-css.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-3.3.1/dt-1.10.21/datatables.min.css"/>

    <!-- modernizr css -->
    <script src="assets/js/vendor/modernizr-2.8.3.min.js"></script>
</head>

<body>
    <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    <!-- preloader area start -->
    <div id="preloader">
        <div class="loader"></div>
    </div>
    <!-- preloader area end -->
    <!-- page container area start -->
    <div class="page-container">
        <!-- sidebar menu area start -->
        <div class="sidebar-menu">
            <div class="sidebar-header">
                <div class="logo">
                    <a href="#" onclick="LoadFrame(null, 'Welcome.php', 'Welcome')"><img src="assets/images/icon/logo.png" alt="logo"></a>
                </div>
            </div>
            <div class="main-menu">
                <div class="menu-inner">
                    <nav>
                        <ul class="metismenu" id="menu">
                            <li class="active">
                                <a href="javascript:void(0)" aria-expanded="true"><i class="ti-dashboard"></i><span>Command Start</span></a>
                                <ul class="collapse">
                                    <li><a href="#" onclick="LoadFrame(this, 'UserSettings.php', 'Command Start')">Change the number of days</a></li>
                                    <li><a href="#" onclick="LoadFrame(this, 'Export.php', 'Command Start')">Export Data</a></li>
                                    <li><a href="#" onclick="LoadFrame(this, 'UserInfo.php', 'Command Start')">User Information</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-align-left"></i>
                                    <span>Website Logs</span></a>
                                <ul class="collapse">
                                    <li><a href="#" onclick="LoadFrame(this, 'LogReader.php', 'Website Logs', 'fileName=inputLog.txt')">Input Messages</a></li>
                                    <li><a href="#" onclick="LoadFrame(this, 'LogReader.php', 'Website Logs', 'fileName=log.txt')">Errors</a></li>
                                </ul>
                            </li>
                            <li><a href="#"  onclick="LoadFrame(this, 'About.html', 'About', '', 'GET')"><i class="ti-map-alt"></i><span>About</span></a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <!-- sidebar menu area end -->
        <!-- main content area start -->
        <div class="main-content">
            <!-- header area start -->
            <div class="header-area">
                <div class="row align-items-center">
                    <!-- nav and search button -->
                    <div class="col-md-6 col-sm-8 clearfix">
                        <div class="nav-btn pull-left">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                    <!-- profile info & task notification -->
                    <div class="col-md-6 col-sm-4 clearfix">
                        <ul class="notification-area pull-right">
                            <li id="full-view"><i class="ti-fullscreen"></i></li>
                            <li id="full-view-exit"><i class="ti-zoom-out"></i></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- header area end -->
            <!-- page title area start -->
            <div class="page-title-area">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <div class="breadcrumbs-area clearfix">
                            <h4 class="page-title pull-left" id="page-title">Command Start</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 clearfix">
                        <div class="user-profile pull-right">
                            <img class="avatar user-thumb" src="assets/images/author/avatar.png" alt="avatar">
                            <h4 class="user-name dropdown-toggle" data-toggle="dropdown">Account<i class="fa fa-angle-down"></i></h4>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="Logout.php">Log Out</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- page title area end -->
            <div class="main-content-inner" id="main-content-inner">
                <!-- MAIN CONTENT GOES HERE -->

            </div>
        </div>
        <!-- main content area end -->
        <!-- footer area start-->
        <footer>
            <div class="footer-area">
                <p>© Copyright. All right reserved.</p>
            </div>
        </footer>
        <!-- footer area end-->
    </div>
    <!-- page container area end -->
    <script>
        function addScript(scriptVal) {
            var s = document.createElement( 'script' );
            s.innerText = scriptVal;
            document.body.appendChild( s );
        }
        var mainContentInner = document.getElementById('main-content-inner');
        var pageTitle = document.getElementById('page-title');
        var previousActiveTab = null;
        function LoadFrame(el, url, title, sendVal = "", method = "POST")
        {
            pageTitle.innerText = title;
            if(previousActiveTab != null) {
                previousActiveTab.classList.remove("active");
            }
            if(el != null) {
                previousActiveTab = el.parentElement;
                previousActiveTab.classList.add("active");
            }
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var parser = new DOMParser();
                    var htmlDoc = parser.parseFromString(this.responseText, 'text/html');
                    var scripts = htmlDoc.getElementsByTagName('script');
                    for(var i=0; i < scripts.length; i++) {
                        addScript(scripts[i].innerText);
                    }
                    mainContentInner.innerHTML = '';
                    mainContentInner.appendChild(htmlDoc.getElementsByTagName('body')[0]);
                }
            };
            xhttp.open(method, url, true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send(sendVal);
        }
        LoadFrame(null, 'Welcome.php', 'Welcome');
    </script>
    <!-- offset area end -->
    <!-- jquery latest version -->
    <script src="assets/js/vendor/jquery-2.2.4.min.js"></script>
    <!-- bootstrap 4 js -->
    <script src="assets/js/popper.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/metisMenu.min.js"></script>
    <script src="assets/js/jquery.slimscroll.min.js"></script>
    <script src="assets/js/jquery.slicknav.min.js"></script>

    <!-- start chart js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
    <!-- start highcharts js -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <!-- start zingchart js -->
    <script src="https://cdn.zingchart.com/zingchart.min.js"></script>
    <script>
        zingchart.MODULESDIR = "https://cdn.zingchart.com/modules/";
        ZC.LICENSE = ["569d52cefae586f634c54f86dc99e6a9", "ee6b7db5b51705a13dc2339db3edaf6d"];
    </script>
    <!-- all line chart activation -->
    <script src="assets/js/line-chart.js"></script>
    <!-- all pie chart -->
    <script src="assets/js/pie-chart.js"></script>
    <!-- others plugins -->
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/scripts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jq-3.3.1/dt-1.10.21/datatables.min.js"></script>

</body>

</html>
