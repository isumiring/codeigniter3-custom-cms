<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <meta name="description" content="CMS - <?=$site_setting['app_title']?>"/>
        <meta name="author" content="Ivan Lubis"/>
        
        <title>CMS - <?=(isset($page_title)) ? $site_setting['app_title'].' : '.$page_title : $site_setting['app_title'] ?></title>

        <!-- Bootstrap Core CSS -->
        <link href="<?=CSS_URL?>bootstrap.min.css" rel="stylesheet"/>

        <!-- MetisMenu CSS -->
        <link href="<?=CSS_URL?>metisMenu.min.css" rel="stylesheet"/>

        <!-- Timeline CSS -->
        <link href="<?=CSS_URL?>timeline.css" rel="stylesheet"/>

        <!-- Custom CSS -->
        <link href="<?=CSS_URL?>sb-admin-2.css" rel="stylesheet"/>
        <link href="<?=CSS_URL?>animate.css" rel="stylesheet"/>
        <link href="<?=GLOBAL_CSS_URL?>custom.css" rel="stylesheet"/>

        <!-- Custom Fonts -->
        <link href="<?=VENDOR_URL?>font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>

    <body>
        
        <div class="container">
            <?=$content?>
            <div class="row">
                <div class="col-md-12 text-center">
                    <?=$site_setting['app_footer']?>
                </div>
            </div>
        </div>

        <!-- jQuery -->
        <script src="<?=GLOBAL_JS_URL?>jquery.min.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="<?=JS_URL?>bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="<?=JS_URL?>metisMenu.min.js"></script>

        <!-- Custom Theme JavaScript -->
        <script src="<?=JS_URL?>sb-admin-2.js"></script>

    </body>

</html>
