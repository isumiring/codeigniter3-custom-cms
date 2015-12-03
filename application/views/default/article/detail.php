<div class="container">
    <div class="row">
        <div class="col-sm-8 blog-main">
            <div class="blog-post">
                <h2 class="blog-post-title"><?=$record['title']?></h2>
                <?php if ($record['primary_image'] != '' && file_exists(UPLOAD_DIR.'article/'.$record['primary_image'])): ?>
                <img class="img-responsive" src="<?=RELATIVE_UPLOAD_DIR.'article/'.$record['primary_image']?>"/>
                <?php endif; ?>
                <?=$record['description']?>
            </div>
        </div>
    </div>
</div>