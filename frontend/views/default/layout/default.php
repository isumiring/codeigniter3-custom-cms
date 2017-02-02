<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="<?php echo $site_setting['web_keywords']; ?>"/>
    <meta name="description" content="<?php echo $site_setting['web_description']; ?>"/>
    <meta name="author" content="Ivan Lubis">

    <title><?php echo $head_title; ?></title>

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo CSS_URL; ?>bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo CSS_URL; ?>modern-business.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?php echo VENDOR_URL; ?>bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo base_url(); ?>"><?php echo $site_setting['app_title']; ?></a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <?php if (isset($main_menus) && count($main_menus) > 0): foreach ($main_menus as $key => $m_menu): ?>
                    <li>
                        <a href="<?php echo $m_menu['menu_href']; ?>" <?php echo $m_menu['attributes']; ?>><?php echo $m_menu['menu_title']; ?></a>
                    </li>
                    <?php endforeach; endif; ?>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <?php echo $content; ?>

    <div class="container">
        <hr />
        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p><?php echo $site_setting['app_footer']; ?></p>
                </div>
            </div>
        </footer>
    </div>

    <!-- jQuery -->
    <script src="<?php echo JS_URL; ?>jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo JS_URL; ?>bootstrap.min.js"></script>

    <!-- Script to Activate the Carousel -->
    <script>
    $('.carousel').carousel({
        interval: 5000 //changes the speed
    })
    </script>

</body>

</html>
