<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <meta name="description" content="CMS - <?php echo $site_setting['app_title']; ?>"/>
        <meta name="author" content="Ivan Lubis"/>
        <meta name="robots" content="noindex" />
        
        <title>CMS - <?php echo (isset($page_title)) ? $site_setting['app_title'].' : '.$page_title : $site_setting['app_title']; ?></title>

        <!-- Bootstrap Core CSS -->
        <link href="<?php echo $CSS_URL; ?>bootstrap.min.css" rel="stylesheet"/>

        <!-- MetisMenu CSS -->
        <link href="<?php echo $CSS_URL; ?>metisMenu.min.css" rel="stylesheet"/>

        <!-- Timeline CSS -->
        <link href="<?php echo $CSS_URL; ?>timeline.css" rel="stylesheet"/>

        <!-- Custom CSS -->
        <link href="<?php echo $CSS_URL; ?>sb-admin-2.css" rel="stylesheet"/>
        <link href="<?php echo $CSS_URL; ?>animate.css" rel="stylesheet"/>
        <link href="<?php echo $GLOBAL_CSS_URL; ?>custom.css" rel="stylesheet"/>

        <!-- Custom Fonts -->
        <link href="<?php echo $VENDOR_URL; ?>font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- jQuery -->
        <script src="<?php echo $GLOBAL_JS_URL; ?>jquery.min.js"></script>

        <!-- global var js -->
        <script type="text/javascript">
            var base_url         = '<?php echo base_url(); ?>';
            var current_ctrl     = '<?php echo current_controller(); ?>';
            var current_url      = '<?php echo current_url(); ?>';
            var assets_url       = '<?php echo $ASSETS_URL; ?>';
            var token_name       = '<?php echo $this->security->get_csrf_token_name(); ?>';
            var token_key        = '<?php echo $this->security->get_csrf_hash(); ?>';
            var objToken         = {};
            objToken[token_name] = token_key;
        </script>

        <script src="<?php echo $GLOBAL_JS_URL; ?>custom.js"></script>

    </head>

    <body>
        
        <div class="container">
            <!-- lets print main content -->
            <?php echo $content; ?>
            
            <div class="row">
                <div class="col-md-12 text-center">
                    <?php echo $site_setting['app_footer']; ?>
                </div>
            </div>
        </div>

        <!-- Bootstrap Core JavaScript -->
        <script src="<?php echo $JS_URL; ?>bootstrap.min.js"></script>
        
        <!-- Custom Theme JavaScript -->
        <script src="<?php echo $JS_URL; ?>sb-admin-2.js"></script>

        <script type="text/javascript">
            $(document).ajaxSuccess(function( event, request, settings, data) {
                if (data['redirect_auth']) {
                    window.location = data['redirect_auth'];
                    return;
                }
            });
        </script>

    </body>

</html>
