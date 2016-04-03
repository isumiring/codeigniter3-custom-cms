<div class="container">
    <div class="row">
        <div class="col-sm-8 blog-main">
            <div class="blog-post">
                <h2 class="blog-post-title"><?php echo $event['title']; ?></h2>
                <h4 class="blog-post-title"><?php echo $event['location']; ?></h4>
                <?php if ($event['primary_image'] != '' && file_exists(UPLOAD_DIR.'event/'.$event['primary_image'])): ?>
                <img class="img-responsive" src="<?php echo RELATIVE_UPLOAD_DIR.'event/'.$event['primary_image']; ?>"/>
                <?php endif; ?>
                <?php echo $event['description']; ?>
            </div>
        </div>
    </div>
</div>