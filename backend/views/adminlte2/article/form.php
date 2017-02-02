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
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="id_article_category">Category <span class="text-danger">*</span></label>
                        <select name="id_article_category" id="id_article_category" class="form-control" required="required">
                            <?php foreach ($categories as $row => $category): ?>
                            <option value="<?php echo $category['id_article_category']; ?>" <?php echo (isset($post['id_article_category']) && $post['id_article_category'] == $category['id_article_category']) ? 'selected="selected"' : ''; ?>><?php echo $category['title']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <?php if ($locales): ?>
                    <div class="nav-tabs-custom localization">
                        <ul class="nav nav-tabs">
                            <?php foreach ($locales as $row => $local): ?>
                            <li role="presentation" <?php echo ($row == 0) ? 'class="active"' : ''; ?>>
                                <a href="#<?php echo $local['iso_2'].'-'.$local['id_localization']; ?>" aria-controls="<?php echo $local['iso_2'].'-'.$local['id_localization']; ?>" role="tab" data-toggle="tab">
                                    <?php echo ucfirst($local['locale']); ?>
                                    <?php echo ($local['locale_status'] == 1) ? ' (Default)' : ''; ?>
                                </a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                        <!--/.nav-tabs-->
                        <div class="tab-content">
                            <?php foreach ($locales as $row => $local): ?>
                            <div role="tabpanel" class="tab-pane fade <?php echo ($row==0) ? 'in active' : ''?>" id="<?php echo $local['iso_2'].'-'.$local['id_localization']?>">
                                <div class="form-group">
                                    <label for="title_<?php echo $local['iso_1']?>">Title (<?php echo ucfirst($local['locale'])?>)<?php echo ($local['locale_status'] == 1) ? ' <span class="text-danger">*</span>' : ''; ?></label>
                                    <input type="text" class="form-control <?php echo ($row==0) ? 'seodef' : ''; ?>" name="locales[<?php echo $local['id_localization']; ?>][title]" id="title_<?php echo $local['iso_1']; ?>" value="<?php echo (isset($post['locales'][$local['id_localization']]['title'])) ? $post['locales'][$local['id_localization']]['title'] : ''; ?>" <?php echo ($local['locale_status'] == 1) ? 'required="required"' : ''; ?>/>
                                </div>
                                <div class="form-group">
                                    <label for="teaser_<?php echo $local['iso_1']; ?>">Teaser (<?php echo ucfirst($local['locale']); ?>)</label>
                                    <textarea class="form-control" rows="10" name="locales[<?php echo $local['id_localization']?>][teaser]" id="teaser_<?php echo $local['iso_1']; ?>"><?php echo (isset($post['locales'][$local['id_localization']]['teaser'])) ? $post['locales'][$local['id_localization']]['teaser'] : ''; ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="description_<?php echo $local['iso_1']; ?>">Description (<?php echo ucfirst($local['locale']); ?>)</label>
                                    <textarea class="form-control editorable" rows="10" name="locales[<?php echo $local['id_localization']; ?>][description]" id="description_<?php echo $local['iso_1']; ?>"><?php echo (isset($post['locales'][$local['id_localization']]['description'])) ? $post['locales'][$local['id_localization']]['description'] : ''; ?></textarea>
                                </div>
                            </div>
                            <?php endforeach; ?>
                            <!--/.tab-pane-->
                        </div>
                        <!-- /.tab content -->
                    </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="uri_path">SEO URL / SLUG <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="uri_path" id="uri_path" value="<?php echo (isset($post['uri_path'])) ? $post['uri_path'] : ''; ?>" required="required"/>
                    </div>
                    <div class="form-group">
                        <label for="id_status">Status <span class="text-danger">*</span></label>
                        <select name="id_status" id="id_status" class="form-control" required="required">
                            <?php foreach ($statuses as $row => $status): ?>
                            <option value="<?php echo $status['id_status']; ?>" <?php echo (isset($post['id_status']) && $post['id_status'] == $status['id_status']) ? 'selected="selected"' : ''; ?>><?php echo $status['status_text']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <label>
                        <input type="checkbox" name="is_featured" id="is_featured" value="1" <?php echo (isset($post['is_featured']) && $post['is_featured'] == 1) ? 'checked="checked"' : ''; ?>/> Featured
                    </label>
                    <div class="form-group">
                        <label for="publish_date">Publish Date <span class="text-danger">*</span></label>
                        <div class="input-group date">
                            <input type="text" class="form-control" name="publish_date" id="publish_date" value="<?php echo (isset($post['publish_date'])) ? $post['publish_date'] : date('Y-m-d'); ?>" readonly="readonly" required="required"/>
                            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="expire_date">Expire Date</label>
                        <div class="input-group date">
                            <input type="text" class="form-control" name="expire_date" id="expire_date" value="<?php echo (isset($post['expire_date'])) ? $post['expire_date'] : ''; ?>" readonly="readonly"/>
                            <span class="input-group-addon expire_date"><i class="glyphicon glyphicon-calendar"></i></span>
                        </div>
                        <label>
                            <input type="checkbox" value="1" name="forever" id="forever" <?php echo ( (isset($post['forever']) && !empty($post['forever'])) || ( (empty($post['expire_date']) || $post['expire_date'] == '0000-00-00' || $post['expire_date'] == '1970-01-01')) ) ? 'checked="checked"' : ''; ?>/> Set as forever
                        </label>
                    </div>
                    <div class="form-group">
                        <label for="thumbnail_image">Thumbnail Image (<?php echo IMG_ARTICLE_THUMB_WIDTH. ' x '. IMG_ARTICLE_THUMB_HEIGHT; ?>)</label>
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="fileinput-new thumbnail fileinput-upload" style="width: 200px; height: 150px;">
                                <?php if (isset($post['thumbnail_image']) && $post['thumbnail_image'] != '' && file_exists(UPLOAD_DIR. $this->router->fetch_class(). '/'.$post['thumbnail_image'])): ?>
                                    <img src="<?php echo RELATIVE_UPLOAD_DIR. $this->router->fetch_class(). '/tmb_'.$post['thumbnail_image']; ?>" id="post-image-thumbnail" />
                                    <span class="btn btn-danger btn-delete-photo delete-picture" id="delete-picture" data-id="<?php echo $post['id']; ?>" data-type="thumbnail">x</span>
                                <?php endif; ?> 
                            </div>
                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
                            <div>
                                <span class="btn btn-default btn-file">
                                    <span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span>
                                    <input type="file" name="thumbnail_image">
                                </span>
                                <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="primary_image">Primary Image (<?php echo IMG_ARTICLE_PRIMARY_WIDTH. ' x FREE'; ?>)</label>
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="fileinput-new thumbnail fileinput-upload" style="width: 200px; height: 150px;">
                                <?php if (isset($post['primary_image']) && $post['primary_image'] != '' && file_exists(UPLOAD_DIR. $this->router->fetch_class(). '/'.$post['primary_image'])): ?>
                                    <img src="<?php echo RELATIVE_UPLOAD_DIR. $this->router->fetch_class(). '/tmb_'.$post['primary_image']; ?>" id="post-image-primary" />
                                    <span class="btn btn-danger btn-delete-photo delete-picture" id="delete-picture" data-id="<?php echo $post['id']; ?>" data-type="primary">x</span>
                                <?php endif; ?>
                            </div>
                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
                            <div>
                                <span class="btn btn-default btn-file">
                                    <span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span>
                                    <input type="file" name="primary_image">
                                </span>
                                <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row button-row">
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
        $('#forever').on('ifChanged', function() {
            var self = $(this);
            if (self.prop('checked') == true) {
                $('#expire_date').attr('disabled', true);
                $('#expire_date').val('');
                $(".input-group-addon.expire_date").addClass('blocked');
            } else {
                $('#expire_date').removeAttr('disabled');
                $('.input-group-addon.expire_date').removeClass('blocked');
            }
        });
        $('#forever').trigger('ifChanged');

        <?php if (isset($post['id'])): ?>
        $('.delete-picture').click(function() {
            var self = $(this);
            var id   = self.attr('data-id');
            var type = self.attr('data-type');
            var data = [
                {'name': 'id', 'value': id},
                {'name': 'type', 'value': type}
            ];
            submit_ajax('<?php echo $delete_picture_url; ?>', data, self)
                .done(function(data) {
                    if (data['error'])  {
                        $('.flash-message').html(data['error']);
                    }
                    if (data['success']) {
                        $('.flash-message').html(data['success']);
                        $('#post-image-'+ type).remove();
                        self.remove();
                    }
                });
        });
        <?php else: ?>
        $('.seodef').keyup(function() {
            $('#uri_path').val(convert_to_uri(this.value));
        });
        <?php endif; ?>
    });
</script>
