<?php
ob_start();
session_start();
//session_destroy();
date_default_timezone_set ('Europe/Copenhagen');
require_once("Include/DBconn.php");
require_once("oneall_sdk/config.php");
require_once("Include/oneall_hlpf/oneall_calls.php");
require_once("Include/UrlContoller.php");
include_once("Include/DEBUGGIN.php");
?>
<!DOCTYPE html>
<html lang="da">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>HLParty <?php if(isset($html_headder_title)){echo '- '.$html_headder_title;} ?></title>
    <link rel="shortcut icon" href="">
    <!-- Stylesheets -->
    <!-- Font awesome -->
    <link rel="stylesheet" href="Style/font-awesome/css/font-awesome.min.css">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="Style/bootstrap.min.css">
    <link rel="stylesheet" href="Style/bootstrap-theme.min.css">
    <?php
      if($page == 'Admin'){
        ?>
    <!-- Bootstrap datetimepicker -->
    <link rel="stylesheet" href="Style/bootstrap-datetimepicker.min.css">
        <?php
      }
    ?>
    <!-- Style override -->
    <link rel="stylesheet" href="Style/hlpf_main.css">
    <!-- Jquery UI -->
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <!-- Seat-chart -->
    <?php
    //if (condition) {
    //  echo "<link rel='stylesheet' type='text/css' href='JS/seat-chart/jquery.seat-chart.min.js'>";
    //}
    ?>
    <!-- TinyMCE -->
    <script type="text/javascript" src="JS/tinymce/tinymce.min.js"></script>
    <script>
        // Public Editor for use at places like Forum, Profile text and so on.
      tinymce.init({
        selector: '#PublicTinyMCE',
        menubar: '',
        toolbar: 'undo redo | bold | blod italic | underline |',
        browser_spellcheck: true
      });
        // Administration Editor for use at places like news, pages, event and so on.
      tinymce.init({
        selector: '#AdminTinyMCE',
        menubar:'',
        plugins: [
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste imagetools"
        ],
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
        browser_spellcheck: true
      });
    </script>
    <!--[if IE]>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- OneAll -->
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
    <script src="JS/Jquery/jquery.min.js"></script>
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
        <?php require_once("Include/TopHeader.php"); ?>
        <!-- Top end -->
        <br>
        <!-- Nav start -->
        <?php require_once("Include/NavigationBar.php"); ?>
        <!-- Nav end -->
    </header>
    <br>
    <div class="container">
    <?php require_once("Include/PageCaller.php"); ?>
    </div>
    <?php require_once("Include/TilesAndTournament.php"); ?>
    <!-- Sponsors start -->
    <hr>
    <?php require_once("Include/Sponsors.php"); ?>
    <!-- Sponsors end -->
    <!-- Footer start -->
    <?php require_once("Include/Footer.php"); ?>
    <!-- Footer end -->
    <script src="JS/Bootstrap/bootstrap.min.js"></script>
    <?php
      if($page == 'Admin'){
        ?>
    <script src="JS/Bootstrap/bootstrap-datetimepicker.js"></script>
    <script src="JS/Bootstrap/bootstrap-datetimepicker.da.js"></script>
     <script type="text/javascript">
      $('.form_datetime').datetimepicker({
          language:  'da',
          weekStart: 1,
          todayBtn:  1,
          autoclose: 1,
          todayHighlight: 1,
          startView: 2,
          forceParse: 0,
          showMeridian: 0
      });
    </script>
      <?php
      }
    ?>
</body>
</html>
