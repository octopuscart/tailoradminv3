<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <head>
        <meta charset="utf-8" />
        <title><?php echo SITE_NAME ?> | Admin Panel</title>
        <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />

        <!-- ================== BEGIN BASE CSS STYLE ================== -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">

        <?php
        $styleSheetArray = array(
            "Jquery" => "assets/plugins/jquery-ui/themes/base/minified/jquery-ui.min.css",
            "Bootstrap3" => "assets/plugins/bootstrap/css/bootstrap.min.css",
            "FontAwesome" => "assets/plugins/font-awesome/css/font-awesome.min.css",
            "Animate" => "assets/css/animate.min.css",
            "Style" => "assets/css/style.min.css",
            "StyleResponsive" => "assets/css/style-responsive.min.css",
            "Default" => "assets/css/theme/default.css",
            "CustomeStyle" => "assets/css/customstyle.css",
            "IonicIcon" => "assets/plugins/ionicons/css/ionicons.min.css",
            "Gitter" => "assets/plugins/gritter/css/jquery.gritter.css",
        );
        foreach ($styleSheetArray as $title => $stylesheet) {
            ?>
                                            <!-- ================== <?php echo $title ?> ================== -->
            <link href="<?php echo base_url(); ?><?php echo $stylesheet; ?>" rel="stylesheet" />
            <?php
        }
        ?>

        <!-- end page container -->	
        <!-- ================== BEGIN BASE JS ================== -->
        <script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery-1.9.1.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery-migrate-1.1.0.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/jquery-ui/ui/minified/jquery-ui.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/moment/moment.min.js"></script>
        <!--[if lt IE 9]>
                <script src="assets/crossbrowserjs/html5shiv.js"></script>
                <script src="assets/crossbrowserjs/respond.min.js"></script>
                <script src="assets/crossbrowserjs/excanvas.min.js"></script>
        <![endif]-->




        <!-- ================== BEGIN BASE JS ================== -->
        <script src="<?php echo base_url(); ?>assets/plugins/pace/pace.min.js"></script>
        <link href="<?php echo base_url(); ?>assets/plugins/gritter/css/jquery.gritter.css" rel="stylesheet" />	
        <!-- ================== END BASE JS ================== -->



        <!--angular js-->
        <script src="<?php echo base_url(); ?>assets/angular/angular.min.js"></script>

        <!--custom style-->
        <style>
<?php echo HEADERCSS; ?>
        </style>
        <!--custom style-->

        <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js" ></script>

        <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap5.min.js" ></script>

        <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js" ></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" ></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js" ></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js" ></script>

        <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js" ></script>

        <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js" ></script>

        <style>
            a.nav-link.active {
                font-weight: 600;
                border-bottom: 1px solid #fff;
            }
        </style>





        <!--<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" type="text/css" />-->
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css" type="text/css" />

    </head>
    <body class="" ng-app="Admin">

        <script>
            var Admin = angular.module('Admin', []).config(function ($interpolateProvider, $httpProvider) {
            //$interpolateProvider.startSymbol('{$');
            //$interpolateProvider.endSymbol('$}');
            $httpProvider.defaults.headers.common = {};
            $httpProvider.defaults.headers.post = {};
            });
            var rootBaseUrl = '<?php echo site_url("/"); ?>';
        </script>
        <!-- begin #page-loader -->
        <div id="page-loader" class="fade in"><span class="spinner"></span></div>
        <!-- end #page-loader -->
        <!-- begin #page-container -->
        <div id="page-container" class="page-sidebar-fixed page-header-fixed" ng-controller="rootController">