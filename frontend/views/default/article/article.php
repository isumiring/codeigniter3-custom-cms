
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><?php echo $page_info['title']; ?></h1>
            <ol class="breadcrumb">
                <?php foreach ($breadcrumbs as $key => $breadcrumb): ?>
                <li <?php echo ( ($key + 1) == count($breadcrumbs)) ? 'class="active"' : ''; ?>>
                    <?php if ( ($key + 1) < count($breadcrumbs)): ?>
                    <a href="<?php echo $breadcrumb['url']; ?>" class="<?php echo $breadcrumb['class']; ?>"><?php echo $breadcrumb['text']; ?></a>
                    <?php else: ?>
                    <?php echo $breadcrumb['text']; ?>
                    <?php endif; ?>
                </li>
                <?php endforeach; ?>
            </ol>
            <!-- /.breadcrumb -->
        </div>
    </div>
    <!-- /.row -->

    <div class="row">
        <div class="side-left-col col-md-8">
            <?php if (isset($records) && count($records) > 0): foreach ($records as $key => $record): ?>
            <h2><a href="<?php echo site_url('article/detail/'. $record['uri_path']); ?>"><?php echo $record['title']; ?></a></h2>
            <p><i class="fa fa-clock-o"></i> <?php echo get_lang_text('general', 'general_text_post_date'); ?> <?php echo custom_date_format($record['publish_date'], 'd M Y'); ?></p>
            <hr>
            <?php if ($record['thumbnail_image'] != '' && file_exists(UPLOAD_DIR. 'article/'. $record['thumbnail_image'])): ?>
            <a href="<?php echo site_url('article/detail/'. $record['uri_path']); ?>">
                <img class="img-responsive img-hover" src="<?php echo RELATIVE_UPLOAD_DIR. 'article/tmb_'. $record['thumbnail_image']; ?>" alt="">
            </a>
            <hr />
            <?php endif; ?>
            <p>
                <?php echo $record['teaser']; ?>
            </p>
            <a class="btn btn-primary" href="<?php echo site_url('article/detail/'. $record['uri_path']); ?>"><?php echo get_lang_text('general', 'general_text_read_more'); ?> <i class="fa fa-angle-right"></i></a>

            <hr>
            <?php endforeach; ?>

            <?php echo $pagination; ?>
            <?php else: ?>
            <p><?php echo get_lang_text('general', 'general_text_empty_record'); ?></p>
            <?php endif; ?>

        </div>
        <!-- /.side-left-col -->

        <div class="side-right-col col-md-4">
            <div class="well">
                <h4>Blog Categories</h4>
                <div class="row">
                    <div class="col-lg-12">
                        <?php if (isset($categories) && count($categories) > 0): ?>
                        <ul class="list-unstyled">
                            <?php foreach ($categories as $key => $category): ?>
                            <li><a href="<?php echo site_url('article/category/'. $category['uri_path']); ?>"><?php echo $category['title']; ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                        <?php endif; ?>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.well -->
        </div>
        <!-- /.side-right-col -->

    </div>
    <!-- /.row -->
</div>