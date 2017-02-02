<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title"><?php echo $page_title; ?> Form</h3>
    </div>
    <!--/.box-header-->

    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-message">
                    <?php 
                    if (isset($form_message)) {
                        echo $form_message;
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php echo form_open($form_action, 'role="form" enctype="multipart/form-data"'); ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li role="presentation" class="active"><a href="#info" aria-controls="info" role="tab" data-toggle="tab">Site Info</a></li>
                            <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Site Settings</a></li>
                        </ul>
                        <!--/.nav-tabs-->

                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane fade in active" id="info">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="site_name">Site Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="site_name" id="site_name" value="<?php echo (isset($post['site_name'])) ? $post['site_name'] : ''; ?>" required="required"/>
                                        </div>
                                        <div class="form-group">
                                            <label for="site_url">Site URL <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="site_url" id="site_url" value="<?php echo (isset($post['site_url'])) ? $post['site_url'] : ''; ?>" required="required"/>
                                        </div>
                                        <div class="form-group">
                                            <label for="site_path">Site Path</label>
                                            <input type="text" class="form-control" name="site_path" id="site_path" value="<?php echo (isset($post['site_path'])) ? $post['site_path'] : ''; ?>"/>
                                        </div>
                                        <div class="form-group">
                                            <label for="site_address">Address</label>
                                            <textarea class="form-control" name="site_address" id="site_address"><?php echo (isset($post['site_address'])) ? $post['site_address'] : ''; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="is_default">Default</label>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" value="1" name="is_default" id="is_default" <?php echo (isset($post['is_default']) && !empty($post['is_default'])) ? 'checked="checked"' : ''; ?>/> Default
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="image">Logo</label>
                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail fileinput-upload" style="width: 200px; height: 150px;">
                                                    <?php if (isset($post['site_logo']) && $post['site_logo'] != '' && file_exists(UPLOAD_DIR. $this->router->fetch_class(). '/'.$post['site_logo'])): ?>
                                                        <img src="<?php echo RELATIVE_UPLOAD_DIR. $this->router->fetch_class(). '/'.$post['site_logo']; ?>" id="post-image" />
                                                        <span class="btn btn-danger btn-delete-photo" id="delete-picture" data-id="<?php echo $post['id']; ?>">x</span>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
                                                <div>
                                                    <span class="btn btn-default btn-file">
                                                        <span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span>
                                                        <input type="file" name="site_logo">
                                                    </span>
                                                    <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--/#info-->

                            <div role="tabpanel" class="tab-pane fade" id="settings">
                                <div class="row">
                                    <?php  foreach ($post['setting'] as $row => $setting): ?>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="<?php echo $row; ?>"><?php echo ucwords(str_replace('_', ' ', $row)); ?> <span class="text-danger">*</span></label>
                                                <textarea class="form-control" name="setting[<?php echo $row; ?>]" id="<?php echo $row; ?>" rows="1"><?=$setting?></textarea>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <!--/#settings-->

                        </div>
                        <!--/.tab-content-->
                    </div>
                    <!--/.nav-tabs-custom-->
                </div>
            </div>
            <!--/.row-->
            <div class="row ">
                <div class="col-md-12 text-left">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a class="btn btn-danger" href="<?php echo $cancel_url; ?>">Cancel</a>
                </div>
            </div>
            <!-- /.row (nested) -->
        <?php echo form_close(); ?>
    </div>
    <!--/.box-body-->
</div>
<!--/.box-->

<script type="text/javascript">
    $(function() {
        <?php if (isset($post['id'])): ?>
        $('#delete-picture').click(function() {
            $('.flash-message').empty();
            var self = $(this);
            var id = $(this).data('id');
            var post_delete = [
                {'name': 'id', 'value': id}
            ];
            submit_ajax('<?php echo $delete_picture_url; ?>', post_delete, self)
                .done(function(data) {
                    if (data['error'])  {
                        $('.flash-message').html(data['error']);
                    }
                    if (data['success']) {
                        $('.flash-message').html(data['success']);
                        $('#post-image').remove();
                        self.remove();
                    }
                });
        });
        <?php endif; ?>
    });
</script>