<?php if (isset($slideshows) && count($slideshows) > 0): ?>
<header id="myCarousel" class="carousel slide">
    <!-- Indicators -->
    <ol class="carousel-indicators">
	    <?php foreach ($slideshows as $key => $slideshow): ?>
        <li data-target="#myCarousel" data-slide-to="<?php echo $key; ?>" <?php echo ($key == 0) ? 'class="active"' : ''; ?>></li>
	    <?php endforeach; ?>
    </ol>
    <!-- /.carousel-indicators -->

    <!-- Wrapper for slides -->
    <div class="carousel-inner">
    	<?php foreach ($slideshows as $key => $slideshow): ?>
        <div class="item <?php echo ($key == 0) ? 'active' : ''; ?>">
            <div class="fill" style="background-image:url('<?php echo RELATIVE_UPLOAD_DIR. 'slideshow/tmb_'. $slideshow['primary_image']; ?>');"></div>
            <div class="carousel-caption">
                <h2><?php echo $slideshow['caption']; ?></h2>
            </div>
        </div>
	    <?php endforeach; ?>
        <!-- /.item -->
    </div>
    <!-- /.carousel-inner -->

    <!-- Controls -->
    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
        <span class="icon-prev"></span>
    </a>
    <a class="right carousel-control" href="#myCarousel" data-slide="next">
        <span class="icon-next"></span>
    </a>
</header>
<!-- /#myCarousel.carousel -->
<?php endif; ?>


<!-- Page Content -->
<div class="container">

    <!-- Marketing Icons Section -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                Welcome to <?php echo $site_info['site_name']; ?>
            </h1>
            <p><?php echo $site_setting['welcome_message']; ?></p>
        </div>
        <div class="row">
            <?php if (isset($categories) && count($categories) > 0): foreach ($categories as $key => $category): ?>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-fw fa-check"></i> <?php echo $category['title']; ?></h4>
                    </div>
                    <div class="panel-body">
                        <?php echo $category['description']; ?>
                        <a href="<?php echo site_url('article/category/'. $category['uri_path']); ?>" class="btn btn-default"><?php echo get_lang_text('general', 'general_text_learn_more'); ?></a>
                    </div>
                </div>
            </div>
            <?php endforeach; endif; ?>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.row -->

</div>

