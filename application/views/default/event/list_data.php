<?php if (isset($records) && count($records) > 0): ?>
    <div class="row">
        <?php foreach ($records as $row => $record): ?>
        <div class="col-lg-4">
            <?php if ($record['thumbnail_image'] != '' && file_exists(UPLOAD_DIR.'event/'.$record['thumbnail_image'])): ?>
            <img class="img-circle" src="<?php echo RELATIVE_UPLOAD_DIR.'event/'.$record['thumbnail_image']; ?>"/>
            <?php endif; ?>
            <h2><?php echo $record['title']; ?></h2>
            <h4><?php echo $record['location']; ?></h4>
            <p><?php echo $record['teaser']; ?></p>
            <p><a class="btn btn-default" href="<?php echo site_url('event/detail/'.$record['uri_path']); ?>" role="button"><?php echo get_lang_text('general', 'general_text_more'); ?> &raquo;</a></p>
        </div><!-- /.col-lg-4 -->
        <?php endforeach; ?>
    </div>
    <div class="pagination-list-data">
        <nav role="navigation">
            <?php echo $pagination; ?>
        </nav>
    </div>
<?php else: ?>
    <div class="empty-error">
        <?php echo get_lang_text('general', 'general_empty_record'); ?>
    </div>
<?php endif; ?>