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
        
        <!-- DataTables CSS -->
        <link href="<?=VENDOR_URL?>datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">

        <!-- DataTables Responsive CSS -->
        <link href="<?=VENDOR_URL?>datatables-responsive/css/dataTables.responsive.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="<?=CSS_URL?>sb-admin-2.css" rel="stylesheet"/>
        <link href="<?=CSS_URL?>animate.css" rel="stylesheet"/>
        <link href="<?=VENDOR_URL?>jasny-bootstrap/css/jasny-bootstrap.min.css" rel="stylesheet"/>
        <link href="<?=CSS_URL?>custom.css" rel="stylesheet"/>

        <!-- Custom Fonts -->
        <link href="<?=VENDOR_URL?>font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- jQuery -->
        <script src="<?=JS_URL?>jquery.min.js"></script>
        
        <!-- DataTables JavaScript --
        <script src="<?=VENDOR_URL?>datatables/media/js/jquery.dataTables.min.js"></script>-->
        
        <script type="text/javascript" charset="utf8" src="<?=VENDOR_URL?>datatables/media/js/jquery.dataTables.min.js"></script>
        <script src="<?=VENDOR_URL?>datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>
        <script type="text/javascript">
            var base_url = '<?= base_url() ?>';
            var current_ctrl = '<?= current_controller() ?>';
            var current_url = '<?= current_url() ?>';
            var assets_url = '<?= ASSETS_URL ?>';
            var token_name = '<?=$this->security->get_csrf_token_name()?>';
            var token_key = '<?=$this->security->get_csrf_hash()?>';
        </script>
        <script src="<?=VENDOR_URL?>jasny-bootstrap/js/jasny-bootstrap.min.js"></script>
        <script src="<?=JS_URL?>custom.js"></script>

    </head>

    <body>

        <div id="wrapper">

            <!-- Navigation -->
            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?=base_url()?>">CONTENT MANAGEMENT SYSTEM - <?=$site_info['site_name']?></a>
                </div>
                <!-- /.navbar-header -->

                <ul class="nav navbar-top-links navbar-right">
                    <li>Hi <?=$ADM_SESSION['admin_name']?></li>
                    <!-- /.dropdown -->
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="<?=site_url('profile')?>"><i class="fa fa-user fa-fw"></i> User Profile</a>
                            </li>
                            <li><a href="<?=site_url('site')?>"><i class="fa fa-gear fa-fw"></i> Site Settings</a>
                            </li>
                            <li class="divider"></li>
                            <li><a href="<?=site_url('logout')?>"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                            </li>
                        </ul>
                        <!-- /.dropdown-user -->
                    </li>
                    <!-- /.dropdown -->
                </ul>
                <!-- /.navbar-top-links -->

                <div class="navbar-default sidebar" role="navigation">
                    <div class="sidebar-nav navbar-collapse">
                        <ul class="nav" id="side-menu">
                            <li>
                                <a href="<?=site_url('dashboard')?>"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                            </li>
                            <?=$left_menu?>
                        </ul>
                    </div>
                    <!-- /.sidebar-collapse -->
                </div>
                <!-- /.navbar-static-side -->
            </nav>
            
            <!-- Page Content -->
            <div id="page-wrapper">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <h1 class="page-header"><?=$page_title?></h1>
                        </div>
                        <!-- /.col-lg-12 -->
                    </div>
                    <ol class="breadcrumb">
                        <?php foreach ($breadcrumbs as $breadcrumb): ?>
                            <li class="<?=$breadcrumb['class']?>">
                                <!--<i class="fa fa-dashboard"></i>--> <?=$breadcrumb['text']?>
                            </li>
                        <?php endforeach; ?>
                    </ol>
                    <!-- /.row -->
                    
                    <!-- /.flash-message -->
                    <div class="flash-message">
                        <?php if (isset($flash_message)) {
                            echo $flash_message;
                        }
                        ?>
                    </div><!-- /.flash-message -->
                    
                    <?=$content?>
                    
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /#page-wrapper -->

        </div>
        <!-- /#wrapper -->
        
        <!-- /#modal -->
        <div class="modal fade" id="dynamic-modal" tabindex="-1" role="dialog" aria-labelledby="dynamicModalLabel" aria-hidden="true">
            
        </div><!-- /#modal -->

        <!-- Bootstrap Core JavaScript -->
        <script src="<?=JS_URL?>bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="<?=JS_URL?>metisMenu.min.js"></script>

        <!-- Custom Theme JavaScript -->
        <script src="<?=JS_URL?>sb-admin-2.js"></script>
        <script type="text/javascript">
            $(function() {
                $("#dynamic-modal").on('hidden.bs.modal', function(e) {
                    e.preventDefault();
                    $("#dynamic-modal").html('');
                });
            });
        </script>

    </body>

</html>
