<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><?php echo $page['title']; ?>
                <!-- <small>Subheading</small> -->
            </h1>
            <?php if (isset($breadcrumbs)): ?>
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
            <?php endif; ?>
        </div>                    
    </div>
    <!-- /.row -->

    <div class="row">
        <?php if ($page['primary_image'] != '' && file_exists(UPLOAD_DIR. 'pages/'. $page['primary_image'])): ?>
        <div class="col-md-6">
            <img class="img-responsive" src="<?php echo RELATIVE_UPLOAD_DIR. 'pages/'. $page['primary_image']; ?>" alt="">
        </div>
        <?php endif; ?>
        <div class="<?php echo ($page['primary_image'] != '' && file_exists(UPLOAD_DIR. 'pages/'. $page['primary_image'])) ? 'col-md-6' : 'col-md-12'; ?>">
            <h2><?php echo $page['title']; ?></h2>
            <?php echo $page['description']; ?>
        </div>
    </div>
    <!-- /.row -->
</div>
