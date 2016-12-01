<?php
ob_start();
session_start();
require_once("/Include/DBconn.php");
require_once("/oneall_sdk/config.php");
require_once("/Include/oneall_hlpf/oneall_calls.php");

echo '<pre>';
echo print_r($_SESSION);
echo '</pre>';

?>
<!DOCTYPE html>
<html lang="da">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>HLParty 2017 style</title>
    <link rel="shortcut icon" href="">
    <link rel="stylesheet" href="Style/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="Style/bootstrap.min.css">
    <link rel="stylesheet" href="Style/bootstrap-theme.min.css">
    <link rel="stylesheet" href="Style/hlpf_main.css">
    <!--[if IE]>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script type="text/javascript">
        /* Replace #your_subdomain# by the subdomain of a Site in your OneAll account */    
        var oneall_subdomain = 'hlpartyjoomla';
        /* The library is loaded asynchronously */
        var oa = document.createElement('script');
        oa.type = 'text/javascript'; oa.async = true;
        oa.src = '//' + oneall_subdomain + '.api.oneall.com/socialize/library.js';
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(oa, s);
    </script>
</head>
<body>
    <!-- Facebook scocial like code prep start -->
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/da_DK/sdk.js#xfbml=1&version=v2.7&appId=1480239178911395";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
    <!-- Facebook scocial like code prep end -->
    <!-- Slider start -->
    <div class="hlpf_no_margin_padding hidden-xs container-fluid">
       <img src="Images/image-slider-5.jpg" class="img-responsive center-block" >
    </div>
    <!-- Slider end -->
    <br>
    <header>
        <!-- Top start -->
        <?php require_once("/Include/TopHeader.php"); ?>
        <!-- Top end -->
        <br>
        <!-- Nav start -->
        <?php require_once("/Include/NavigationBar.php"); ?>
        <!-- Nav end -->
    </header>
    <br>
    <div class="container">
    <?php require_once("/Include/PageCaller.php"); ?>
    </div>
    <?php require_once("/Include/TilesAndTournament.php"); ?>
    <!-- Sponsors start -->
    <hr>
    <?php require_once("/Include/Sponsors.php"); ?>
    <!-- Sponsors end -->
    <!-- Footer start -->
    <?php require_once("/Include/Footer.php"); ?>
    <!-- Footer end -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</body>
</html>