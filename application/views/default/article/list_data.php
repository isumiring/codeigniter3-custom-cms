<?php if (isset($records) && count($records) > 0): ?>
    <div class="row">
        <?php foreach ($records as $row => $record): ?>
        <div class="col-lg-4">
            <?php if ($article['thumbnail_image'] != '' && file_exists(UPLOAD_DIR.'article/'.$article['thumbnail_image'])): ?>
            <img class="img-circle" src="<?=RELATIVE_UPLOAD_DIR.'article/'.$article['thumbnail_image']?>"/>
            <?php endif; ?>
            <h2><?=$article['title']?></h2>
            <p><?=$article['teaser']?></p>
            <p><a class="btn btn-default" href="<?=site_url('article/detail/'.$article['uri_path'])?>" role="button"><?=get_lang_text('general','general_text_more')?> &raquo;</a></p>
        </div><!-- /.col-lg-4 -->
        <?php endforeach; ?>
    </div>
    <div class="pagination-list-data">
        <nav role="navigation">
            <?= $pagination ?>
        </nav>
    </div>
<?php else: ?>
    <div class="empty-error">
        <?=get_lang_text('general','general_empty_record')?>
    </div>
<?php endif; ?>