<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <meta name="description" content="CMS - <?php echo $site_setting['app_title']; ?>"/>
        <meta name="author" content="Ivan Lubis"/>
        <meta name="creator" content="Ivan Lubis"/>
        <meta name="robots" content="noindex" />
        
        <title>CMS - <?php echo (isset($page_title)) ? $site_setting['app_title'].' : '.$page_title : $site_setting['app_title']; ?></title>

        <!-- Bootstrap Core CSS -->
        <link href="<?php echo $VENDOR_URL; ?>bootstrap/css/bootstrap.min.css" rel="stylesheet"/>

        <!-- Font Awesome -->
        <link href="<?php echo $VENDOR_URL; ?>font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>

        <!-- Ionicons -->
        <link href="<?php echo $VENDOR_URL; ?>ionicons/css/ionicons.min.css" rel="stylesheet" type="text/css"/>

        <!-- DataTables -->
        <link href="<?php echo $GLOBAL_VENDOR_URL; ?>datatables/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet" type="text/css"/>
        <!-- DataTables Responsive CSS -->
        <link href="<?php echo $GLOBAL_VENDOR_URL; ?>datatables/datatables-responsive/css/dataTables.responsive.css" rel="stylesheet" type="text/css"/>

        <!-- Theme style -->
        <link href="<?php echo $CSS_URL; ?>AdminLTE.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo $CSS_URL; ?>skins/skin-blue.min.css" rel="stylesheet" type="text/css"/>

        <!-- iCheck -->
        <link href="<?php echo $VENDOR_URL; ?>iCheck/all.css" rel="stylesheet" type="text/css"/>

        <!-- Date Picker -->
        <link rel="stylesheet" href="<?php echo $VENDOR_URL; ?>datepicker/datepicker3.css">

        <!-- Daterange picker -->
        <link rel="stylesheet" href="<?php echo $VENDOR_URL; ?>daterangepicker/daterangepicker-bs3.css">

        <!-- Jasny Bootstrap -->
        <link href="<?php echo $VENDOR_URL; ?>jasny-bootstrap/css/jasny-bootstrap.min.css" rel="stylesheet"/>

        <!-- Custom CSS -->
        <link href="<?php echo $GLOBAL_CSS_URL; ?>animate.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo $GLOBAL_CSS_URL; ?>custom.css" rel="stylesheet" type="text/css"/>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- jQuery -->
        <script src="<?php echo $GLOBAL_JS_URL; ?>jquery.min.js"></script>
        
        <!-- DataTables JavaScript -->
        <script type="text/javascript" charset="utf8" src="<?php echo $GLOBAL_VENDOR_URL; ?>datatables/media/js/jquery.dataTables.min.js"></script>
        <script src="<?php echo $GLOBAL_VENDOR_URL; ?>datatables/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

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
        <script src="<?php echo $VENDOR_URL; ?>jasny-bootstrap/js/jasny-bootstrap.min.js"></script>
        
        <!-- Editor -->
        <script type="text/javascript" src="<?php echo $GLOBAL_VENDOR_URL; ?>tinymce/js/tinymce/tinymce.min.js"></script>
        <script type="text/javascript">
            tinymce.init({
                'selector': '.editorable'
            });
        </script>

        <script src="<?php echo $GLOBAL_JS_URL; ?>custom.js"></script>
    </head>    
    <body class="adminlte2 hold-transition skin-blue sidebar-mini <?php echo $this->router->fetch_class(). '-'. $this->router->fetch_method(); ?>">
        <div class="wrapper">
            <header class="main-header">
                <a href="<?php echo base_url(); ?>" class="logo">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini"><b>FAT</b></span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg"><b>FAT</b>CMS</span>
                </a>
                <!--/.logo-->

                <nav class="navbar navbar-static-top" role="navigation">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <!--/.sidebar-toggle-->

                    <div class="navbar-custom-menu">
                        <span class="app-title">CONTENT MANAGEMENT SYSTEM - <?php echo $site_info['site_name']; ?></span>
                        <ul class="nav navbar-nav">
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <?php if (isset($user_data['image']) && $user_data['image'] != '' && file_exists(UPLOAD_DIR. 'admin/'. $user_data['image'])): ?>
                                    <img src="<?php echo RELATIVE_UPLOAD_DIR. 'admin/sml_'. $user_data['image']; ?>" class="user-image" alt="<?php echo $ADM_SESSION['admin_name']; ?>">
                                    <?php endif; ?>
                                    <span class="hidden-xs">Hi! <?php echo $ADM_SESSION['admin_name']; ?></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="user-header">
                                        <?php if (isset($user_data['image']) && $user_data['image'] != '' && file_exists(UPLOAD_DIR. 'admin/'. $user_data['image'])): ?>
                                        <img src="<?php echo RELATIVE_UPLOAD_DIR. 'admin/tmb_'. $user_data['image']; ?>" class="img-circle" alt="<?php echo $ADM_SESSION['admin_name']; ?>">
                                        <?php endif; ?>
                                        <p>
                                            <?php echo $ADM_SESSION['admin_name']; ?>
                                            <small>Member since: <?php echo custDateFormat($user_data['create_date'], 'F, Y'); ?></small>
                                            <small>Last login: <?php echo custDateFormat($ADM_SESSION['admin_last_login'], 'd-m-Y H:i'); ?></small>
                                        </p>
                                    </li>
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <a href="<?php echo site_url('profile'); ?>" class="btn btn-default btn-flat">Profile</a>
                                        </div>
                                        <div class="pull-right">
                                            <a href="<?php echo site_url('logout'); ?>" class="btn btn-default btn-flat">Sign out</a>
                                        </div>
                                    </li>
                                </ul>
                                <!--/.dropdown-menu-->
                            </li>
                            <!--/.user-menu-->
                        </ul>
                        <!--/.nav-->
                    </div>
                    <!--/.navbar-custom-menu-->

                </nav>
                <!--/.navbar-->
            </header>
            <!--/.main-header-->

            <aside class="main-sidebar">
                <section class="sidebar">
                    <ul class="sidebar-menu">
                        <li class="header">MAIN NAVIGATION</li>
                        <li><a href="<?php echo site_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
                        <?php echo $main_menu; ?>
                    </ul>
                    <!--/.sidebar-menu-->
                </section>
                <!-- /.sidebar -->
            </aside>
            <!--/.main-sidebar-->

            <div class="content-wrapper">
                <section class="content-header">
                    <h1><?php echo $page_title; ?></h1>
                    <ol class="breadcrumb">
                        <?php foreach ($breadcrumbs as $breadcrumb): ?>
                            <li class="<?php echo $breadcrumb['class']; ?>">
                                <a href="<?php echo $breadcrumb['url']; ?>"><?php echo $breadcrumb['text']; ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ol>
                    <!--/.breadcrumb-->
                </section>
                <!--/.content-header-->

                <section class="content">
                    <div class="flash-message persistent-message">
                        <?php if (isset($flash_message)) {
                            echo $flash_message;
                        } ?>
                        <?php if (isset($persistent_message)) {
                            echo $persistent_message;
                        } ?>
                    </div>
                    <!--/.flash-message.persistent-message-->

                    <?php echo $content; ?>
                </section>
                <!--/.content-->

            </div>
            <!--/.content-wrapper-->

            <footer class="main-footer text-center">
                <?php echo $site_setting['app_footer']; ?>
            </footer>
            <!--/.main-footer-->

        </div>
        <!--/.wrapper-->
        
        <!-- /#modal -->
        <div class="modal fade" id="dynamic-modal" tabindex="-1" role="dialog" aria-labelledby="dynamicModalLabel" aria-hidden="true">
            
        </div><!-- /#modal -->

        <!-- Bootstrap Core JavaScript -->
        <script src="<?php echo $VENDOR_URL; ?>bootstrap/js/bootstrap.min.js"></script>

        <!-- jQuery UI 1.11.4 --
        <script src="<?php echo $JS_URL; ?>jquery-ui.min.js"></script>
        <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip --
        <script>
            $.widget.bridge('uibutton', $.ui.button);
        </script>
        -->

        <!-- daterangepicker -->
        <script src="<?php echo $VENDOR_URL; ?>daterangepicker/moment.min.js"></script>
        <script src="<?php echo $VENDOR_URL; ?>daterangepicker/daterangepicker.js"></script>

        <!-- datetimepicker -->
        <link href="<?php echo $VENDOR_URL; ?>bootstrap-datetimepicker/bootstrap-datetimepicker.min.css" rel="stylesheet" />
        <script src="<?php echo $VENDOR_URL; ?>bootstrap-datetimepicker/bootstrap-datetimepicker.min.js"></script>

        <!-- datepicker -->
        <script src="<?php echo $VENDOR_URL; ?>datepicker/bootstrap-datepicker.js"></script>

        <!-- Slimscroll -->
        <script src="<?php echo $VENDOR_URL; ?>slimScroll/jquery.slimscroll.min.js"></script>

        <!-- FastClick -->
        <script src="<?php echo $VENDOR_URL; ?>fastclick/fastclick.min.js"></script>

        <!-- AdminLTE App -->
        <script src="<?php echo $JS_URL; ?>app.min.js"></script>
        
        <!-- Numeric -->
        <script src="<?php echo $GLOBAL_JS_URL; ?>jquery.numeric.min.js"></script>
        
        <!-- selectpicker -->
        <link href="<?php echo $GLOBAL_VENDOR_URL; ?>bootstrap-selectpicker/css/bootstrap-select.min.css" rel="stylesheet"/>
        <script type="text/javascript" src="<?php echo $GLOBAL_VENDOR_URL; ?>bootstrap-selectpicker/js/bootstrap-select.min.js"></script>

        <!-- iCheck 1.0.1 -->
        <script src="<?php echo $VENDOR_URL; ?>iCheck/icheck.min.js"></script>
        
        <script type="text/javascript">
            $(function() {
                // tabs
                $('#tabster ul a').click(function (e) {
                    e.preventDefault();
                    $(this).tab('show');
                });

                // dynamic modal
                $("#dynamic-modal").on('hidden.bs.modal', function(e) {
                    e.preventDefault();
                    $("#dynamic-modal").empty();
                });

                // date picker
                $('.datepicker, .input-group.date').datepicker({
                    keyboardNavigation: false,
                    autoclose: true,
                    todayHighlight: true,
                    format: "yyyy-mm-dd"
                });

                // date range picker
                $('.daterangepicker input, .daterangepicker .input-group.date').daterangepicker({
                    timePicker: true,
                    timePickerIncrement: 30,
                    format: "YYYY-MM-DD hh:mm"
                });

                $('.datetimepicker').datetimepicker({
                    'ignoreReadonly':true,
                    'format':'YYYY-MM-DD HH:mm'
                });

                // select picker
                $('.selectpicker').selectpicker();

                //Flat color scheme for iCheck
                $('.iCheckBox, input[type=checkbox]').iCheck({
                    checkboxClass: 'icheckbox_square-blue',
                    radioClass: 'iradio_square-blue',
                    // checkboxClass: 'icheckbox_flat-green',
                    // radioClass: 'iradio_flat-green'
                });

                // number only
                $(document).on('keyup change', '.number-only', function() {
                    $(this).numeric();
                });
            });
            $(document).ajaxSuccess(function( event, request, settings, data) {
                if (data['redirect_auth']) {
                    window.location = data['redirect_auth'];
                    return;
                }
            });
        </script>

    </body>

</html>
