<div class="container">
    <?php if ($slideshows): ?>
    <!-- Carousel
    ================================================== -->
    <div id="home-slider" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            <?php foreach ($slideshows as $row => $slideshow): ?>
            <li data-target="#home-slider" data-slide-to="<?php echo $row; ?>" <?php echo ($row == 0) ? 'class="active"' : ''; ?> ></li>
            <?php endforeach; ?>
        </ol>
        <div class="carousel-inner" role="listbox">
            <?php foreach ($slideshows as $row => $slideshow): ?>
            <div class="item <?php echo ($row == 0) ? 'active' : ''; ?>">
                <img src="<?php echo RELATIVE_UPLOAD_DIR.'slideshow/'.$slideshow['primary_image']; ?>" alt="<?php echo $slideshow['title']; ?>"/>
            </div>
            <?php endforeach; ?>
        </div>
        <a class="left carousel-control" href="#home-slider" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#home-slider" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div><!-- /.carousel -->
    <?php endif; ?>
</div>
<div class="container article-featured">
    <?php if ($featured_articles): ?>
    <!-- Three columns of text below the carousel -->
    <div class="row">
        <?php foreach ($featured_articles as $row => $article): ?>
        <div class="col-lg-4">
            <?php if ($article['thumbnail_image'] != '' && file_exists(UPLOAD_DIR.'article/'.$article['thumbnail_image'])): ?>
            <img class="img-thumbnail" src="<?php echo RELATIVE_UPLOAD_DIR.'article/'.$article['thumbnail_image']; ?>"/>
            <?php endif; ?>
            <h2><?php echo $article['title']; ?></h2>
            <p><?php echo $article['teaser']; ?></p>
            <p><a class="btn btn-default" href="<?php echo site_url('article/detail/'.$article['uri_path']); ?>" role="button"><?php echo get_lang_text('general', 'general_text_more'); ?> &raquo;</a></p>
        </div><!-- /.col-lg-4 -->
        <?php endforeach; ?>
    </div><!-- /.row -->
    <?php endif; ?>
</div>