<!-- Page Content -->
<div class="container">

    <!-- Page Heading/Breadcrumbs -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">404
                <small><?php echo $error_heading; ?></small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url(); ?>">Home</a></li>
                <li class="active">404</li>
            </ol>
        </div>
    </div>
    <!-- /.row -->

    <div class="row">

        <div class="col-lg-12">
            <div class="jumbotron">
                <h1><span class="error-404"><?php echo $error_heading; ?></span></h1>
                <p><?php echo $error_message; ?></p>
            </div>
            <!-- /.jumbotron -->
        </div>
    </div>
</div>
<!-- /.container -->
