<div class="container">
    <div class="row">
        <div class="col-sm-8 blog-main">
            <div class="blog-post">
                <h2 class="blog-post-title"><?php echo $record['title']; ?></h2>
                <?php if ($record['primary_image'] != '' && file_exists(UPLOAD_DIR.'pages/'.$record['primary_image'])): ?>
                <img class="img-responsive" src="<?php echo RELATIVE_UPLOAD_DIR.'pages/'.$record['primary_image']; ?>"/>
                <?php endif; ?>
                <?php echo $record['description']; ?>
            </div>
        </div>
    </div>
</div>