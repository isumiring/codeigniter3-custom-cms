<div class="container">
    <div class="row">
        <div class="col-sm-8 blog-main">
            <div class="blog-post">
                <h2 class="blog-post-title"><?php echo $article['title']; ?></h2>
                <?php if ($article['primary_image'] != '' && file_exists(UPLOAD_DIR.'article/'.$article['primary_image'])): ?>
                <img class="img-responsive" src="<?php echo RELATIVE_UPLOAD_DIR.'article/'.$article['primary_image']; ?>"/>
                <?php endif; ?>
                <?php echo $article['description']; ?>
            </div>
        </div>
    </div>
</div>