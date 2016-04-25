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
        <?php echo form_open($form_action,'role="form" enctype="multipart/form-data" id="form-pages"'); ?>
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="parent_page">Parent <span class="text-danger">*</span></label>
                        <select class="form-control" name="parent_page" id="parent_page" required="required">
                            <option value="0">ROOT</option>
                            <?php echo $parent_html; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="page_name">Page Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" required="required" name="page_name" id="page_name" value="<?php echo (isset($post['page_name'])) ? $post['page_name'] : ''; ?>"/>
                    </div>
                    <?php if ($locales): ?>
                    <div class="nav-tabs-custom localization-title">
                        <ul class="nav nav-tabs">
                            <?php foreach ($locales as $row => $local): ?>
                            <li role="presentation" <?php echo ($row == 0) ? 'class="active"' : ''; ?>>
                                <a href="#title-<?php echo $local['iso_2'].'-'.$local['id_localization']; ?>" aria-controls="title-<?php echo $local['iso_2'].'-'.$local['id_localization']; ?>" role="tab" data-toggle="tab">
                                    <?php echo ucfirst($local['locale']); ?>
                                    <?php echo ($local['locale_status'] == 1) ? ' (Default)' : ''; ?>
                                </a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                        <!--/.nav-tabs-->
                        <div class="tab-content">
                            <?php foreach ($locales as $row => $local): ?>
                            <div role="tabpanel" class="tab-pane fade <?php echo ($row == 0) ? 'in active' : ''; ?>" id="title-<?php echo $local['iso_2'].'-'.$local['id_localization']; ?>">
                                <div class="form-group">
                                    <label for="title_<?php echo $local['iso_1']; ?>">Title (<?php echo ucfirst($local['locale']); ?>)</label>
                                    <input type="text" class="form-control <?php echo ($row == 0) ? 'seodef' : ''; ?>" name="locales[<?php echo $local['id_localization']; ?>][title]" id="title_<?php echo $local['iso_1']; ?>" value="<?php echo (isset($post['locales'][$local['id_localization']]['title'])) ? $post['locales'][$local['id_localization']]['title'] : ''; ?>"/>
                                </div>
                            </div>
                            <?php endforeach; ?>
                            <!--/.tab-pane-->
                        </div>
                        <!-- /.tab content -->
                    </div>
                    <?php endif; ?>
                    <div class="">
                        <label class="control-label" style="display: block;">Page Type <span class="text-danger">*</span></label>
                        <label class="radio-inline">
                            <input type="radio" name="page_type" class="required iCheckBox" id="static_page" value="1" <?php echo (isset($post['page_type']) && $post['page_type'] == 1) ? 'checked="checked"' : ''; ?> /> Static Page
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="page_type" class="required iCheckBox" id="module" value="2" <?php echo (isset($post['page_type']) && $post['page_type'] == 2) ? 'checked="checked"' : ''; ?> /> Module
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="page_type" class="required iCheckBox" id="ext_link" value="3" <?php echo (isset($post['page_type']) && $post['page_type'] == 3) ? 'checked="checked"' : ''; ?> /> External URL
                        </label>
                    </div>
                    <div class="content-static-page" style="display: none; margin-top: 20px;">
                        <div class="form-group">
                            <label for="uri_path">SEO URL / SLUG</label>
                            <input type="text" class="form-control" name="uri_path" id="uri_path" value="<?php echo (isset($post['uri_path'])) ? $post['uri_path'] : ''; ?>"/>
                        </div>
                        <?php if ($locales): ?>
                        <div class="nav-tabs-custom localization-static">
                            <ul class="nav nav-tabs">
                                <?php foreach ($locales as $row => $local): ?>
                                <li role="presentation" <?php echo ($row == 0) ? 'class="active"' : ''; ?>>
                                    <a href="#static-<?php echo $local['iso_2'].'-'.$local['id_localization']; ?>" aria-controls="static-<?php echo $local['iso_2'].'-'.$local['id_localization']; ?>" role="tab" data-toggle="tab">
                                        <?php echo ucfirst($local['locale']); ?>
                                        <?php echo ($local['locale_status'] == 1) ? ' (Default)' : ''; ?>
                                    </a>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                            <!--/.nav-tabs-->
                            <div class="tab-content">
                                <?php foreach ($locales as $row => $local): ?>
                                <div role="tabpanel" class="tab-pane fade <?php echo ($row == 0) ? 'in active' : ''; ?>" id="static-<?php echo $local['iso_2'].'-'.$local['id_localization']; ?>">
                                    <div class="form-group">
                                        <label for="teaser_<?php echo $local['iso_1']; ?>">Teaser (<?php echo ucfirst($local['locale']); ?>)</label>
                                        <textarea class="form-control" rows="4" name="locales[<?php echo $local['id_localization']; ?>][teaser]" id="teaser_<?php echo $local['iso_1']; ?>"><?php echo (isset($post['locales'][$local['id_localization']]['teaser'])) ? $post['locales'][$local['id_localization']]['teaser'] : ''; ?></textarea>
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
                    <div class="content-module" style="display: none; margin-top: 20px;">
                        <div class="form-group">
                            <label for="module">Module</label>
                            <input type="text" class="form-control" name="module" id="module" value="<?php echo (isset($post['module'])) ? $post['module'] : ''; ?>"/>
                        </div>
                    </div>
                    <div class="content-ext-link" style="display: none; margin-top: 20px;">
                        <div class="form-group">
                            <label for="ext_link">External URL</label>
                            <input type="text" class="form-control" name="ext_link" id="ext_link" placeholder="with http://" value="<?php echo (isset($post['ext_link'])) ? $post['ext_link'] : ''; ?>"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="position">Position</label>
                        <input type="number" class="form-control" min="1" step="1" name="position" id="position" value="<?php echo (isset($post['position'])) ? $post['position'] : $max_position; ?>"/>
                    </div>
                    <div class="form-group">
                        <label for="id_status">Status <span class="text-danger">*</span></label>
                        <select name="id_status" id="id_status" class="form-control" required="required">
                            <?php foreach ($statuses as $row => $status): ?>
                            <option value="<?php echo $status['id_status']; ?>" <?php echo (isset($post['id_status']) && $post['id_status'] == $status['id_status']) ? 'selected="selected"' : ''; ?>><?php echo $status['status_text']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>
                            <input type="checkbox" value="1" name="is_featured" id="is_featured" <?php echo (isset($post['is_featured']) && ! empty($post['is_featured'])) ? 'checked="checked"' : ''; ?>/> Featured
                        </label>
                    </div>
                    <div class="form-group">
                        <label>
                            <input type="checkbox" value="1" name="is_header" id="is_header" <?php echo (isset($post['is_header']) && ! empty($post['is_header'])) ? 'checked="checked"' : ''; ?>/> Show in Header
                        </label>
                    </div>
                    <div class="form-group">
                        <label>
                            <input type="checkbox" value="1" name="is_footer" id="is_footer" <?php echo (isset($post['is_footer']) && ! empty($post['is_footer'])) ? 'checked="checked"' : ''; ?>/> Show in Footer
                        </label>
                    </div>
                    <div class="form-group">
                        <label for="thumbnail_image">Thumbnail Image</label>
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="fileinput-new thumbnail fileinput-upload" style="width: 200px; height: 150px;">
                                <?php if (isset($post['thumbnail_image']) && $post['thumbnail_image'] != '' && file_exists(UPLOAD_DIR. $this->router->fetch_class(). '/'.$post['thumbnail_image'])): ?>
                                    <img src="<?php echo RELATIVE_UPLOAD_DIR. $this->router->fetch_class(). '/tmb_'.$post['thumbnail_image']; ?>" id="post-image-thumbnail" />
                                    <span class="btn btn-danger btn-delete-photo delete-picture" id="delete-picture" data-id="<?php echo $post['id_page']; ?>" data-type="thumbnail">x</span>
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
                        <label for="primary_image">Primary Image</label>
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="fileinput-new thumbnail fileinput-upload" style="width: 200px; height: 150px;">
                                <?php if (isset($post['primary_image']) && $post['primary_image'] != '' && file_exists(UPLOAD_DIR. $this->router->fetch_class(). '/'.$post['primary_image'])): ?>
                                    <img src="<?php echo RELATIVE_UPLOAD_DIR. $this->router->fetch_class(). '/tmb_'.$post['primary_image']; ?>" id="post-image-primary" />
                                    <span class="btn btn-danger btn-delete-photo delete-picture" id="delete-picture" data-id="<?php echo $post['id_page']; ?>" data-type="primary">x</span>
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
                    <div class="form-group">
                        <label for="background_image">Background Image</label>
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="fileinput-new thumbnail fileinput-upload" style="width: 200px; height: 150px;">
                                <?php if (isset($post['background_image']) && $post['background_image'] != '' && file_exists(UPLOAD_DIR. $this->router->fetch_class(). '/'.$post['background_image'])): ?>
                                    <img src="<?php echo RELATIVE_UPLOAD_DIR. $this->router->fetch_class(). '/tmb_'.$post['background_image']; ?>" id="post-image-primary" />
                                    <span class="btn btn-danger btn-delete-photo delete-picture" id="delete-picture" data-id="<?php echo $post['id_page']; ?>" data-type="background">x</span>
                                <?php endif; ?>
                            </div>
                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
                            <div>
                                <span class="btn btn-default btn-file">
                                    <span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span>
                                    <input type="file" name="background_image">
                                </span>
                                <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
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
        $('.seodef').keyup(function() {
            $('#uri_path').val(convert_to_uri(this.value));
        });
        <?php if (isset($post['id_page'])): ?>
        $('.delete-picture').click(function() {
            $('.flash-message').empty();
            var self = $(this);
            var id = self.attr('data-id');
            var type = self.attr('data-type');
            var data = [
                {'name': 'id', 'value': id},
                {'name': 'type', 'value': type}
            ];
            submit_ajax('<?php echo $delete_picture_url; ?>', data, self)
                .done(function(data) {
                    if (data['error']) {
                        $('.flash-message').html(data['error']);
                    }
                    if (data['success']) {
                        $('.flash-message').html(data['success']);
                        $('#post-image-'+ type).remove();
                        self.remove();
                    }
                });
        });
        <?php endif; ?>
        $(function() {
            $('input[name=page_type]').on('ifClicked', function() {
                var self = $(this);
                if (self.val() == 1) {
                    // static page
                    $('.content-module, .content-ext-link').slideUp('fast', function() {
                        $('.content-static-page').delay(500).slideDown('slow');
                    });
                } else if (self.val() == 2) {
                    // module
                    $('.content-static-page, .content-ext-link').slideUp('fast', function() {
                        $('.content-module').delay(500).slideDown('slow');
                    });
                } else if (self.val() == 3) {
                    // external link
                    $('.content-static-page, .content-module').slideUp('fast', function() {
                        $('.content-ext-link').delay(500).slideDown('slow');
                    });
                } else {
                    // default
                    $('.content-static-page, .content-module, .content-ext-link').hide();
                }
            });
            $('input[name=page_type]:checked').trigger('ifClicked');
        });
    });
</script>
