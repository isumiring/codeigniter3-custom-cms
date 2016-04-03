<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $head_title; ?></title>
        <meta name="keywords" content="<?php echo $site_setting['web_keywords']; ?>"/>
        <meta name="description" content="<?php echo $site_setting['web_description']; ?>"/>
        <meta name="author" content="Ivan Lubis"/>
        
        <!-- load stylesheets-->
        <!-- Bootstrap core CSS -->
        <link href="<?php echo CSS_URL; ?>bootstrap.min.css" rel="stylesheet"/>

        <link href="<?php echo CSS_URL; ?>custom.css" rel="stylesheet"/>

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- load adaptor -->
        <script src="<?php echo JS_URL; ?>jquery.min.js"></script>
        
        <!-- global var js -->
        <script type="text/javascript">
            var base_url         = '<?php echo base_url(); ?>';
            var current_ctrl     = '<?php echo current_controller(); ?>';
            var current_url      = '<?php echo current_url(); ?>';
            var assets_url       = '<?php echo ASSETS_URL; ?>';
            var img_url          = '<?php echo IMG_URL; ?>';
            var token_name       = '<?php echo $this->security->get_csrf_token_name(); ?>';
            var token_key        = '<?php echo $this->security->get_csrf_hash(); ?>';
            var objToken         = {};
            objToken[token_name] = token_key;
        </script>
        <script type="text/javascript" src="<?php echo JS_URL; ?>custom.js"></script>
    </head>
    <body class="<?php echo strtolower($this->router->fetch_class().'-'.$this->router->fetch_method()); ?>">
        <div class="navbar-wrapper">
            <div class="container">
                <nav class="navbar navbar-inverse navbar-static-top">
                    <div class="container">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <a class="navbar-brand" href="#"><?php echo $site_info['site_name']; ?></a>
                        </div>
                        <div id="navbar" class="navbar-collapse collapse">
                            <ul class="nav navbar-nav">
                                <?php echo $print_main_menu; ?>
                            </ul>
                        </div>
                    </div>
                </nav>

            </div>
        </div>

        <?php echo $content; ?>

        <hr class="featurette-divider"/>

        <!-- FOOTER -->
        <footer>
            <div class="container">
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <?php echo $print_footer_menu; ?>
                    </ul>
                </div>
                <p class="pull-left"><?php echo $site_setting['app_footer']; ?> </p>
                <p class="pull-right"><a href="#">Back to top</a></p>
            </div>
        </footer>

        <!-- Bootstrap core JavaScript
        ================================================== -->
        <script src="<?php echo JS_URL; ?>bootstrap.min.js"></script>
    </body>
</html>