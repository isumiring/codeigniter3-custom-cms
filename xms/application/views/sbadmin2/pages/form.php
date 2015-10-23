<div class="row">
    <div class="col-lg-12">
        <div class="form-message">
            <?php 
            if (isset($form_message)) {
                echo $form_message;
            }
            ?>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <?=$page_title?> Form
            </div>
            <div class="panel-body">
                <?php echo form_open($form_action,'role="form" enctype="multipart/form-data" id="form-pages"'); ?>
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="form-group">
                                <label for="parent_page">Parent</label>
                                <select class="form-control" name="parent_page" id="parent_page">
                                    <option value="0">ROOT</option>
                                    <?=$parent_html?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="page_name">Page Name</label>
                                <input type="text" class="form-control" required="required" name="page_name" id="page_name" value="<?= (isset($post['page_name'])) ? $post['page_name'] : '' ?>"/>
                            </div>
                            <?php if ($locales): ?>
                            <div class="localization" role="tabpanel" id="tabster">
                                <ul class="nav nav-tabs" role="tablist">
                                    <?php foreach ($locales as $row => $local): ?>
                                    <li role="presentation" <?=($row==0) ? 'class="active"' : ''?>>
                                        <a href="#<?=$local['iso_2'].'-'.$local['id_localization']?>" aria-controls="<?=$local['iso_2'].'-'.$local['id_localization']?>" role="tab" data-toggle="tab">
                                            <?=ucfirst($local['locale'])?>
                                            <?=($local['locale_status']==1)?' (Default)':''?>
                                        </a>
                                    </li>
                                    <?php endforeach; ?>
                                </ul><!-- Nav tabs -->
                                <!-- /.tab content -->
                                <div class="tab-content">
                                    <?php foreach ($locales as $row => $local): ?>
                                    <div role="tabpanel" class="tab-pane fade <?=($row==0) ? 'in active' : ''?>" id="<?=$local['iso_2'].'-'.$local['id_localization']?>">
                                        <div class="form-group">
                                            <label for="title_<?=$local['iso_1']?>">Title (<?=ucfirst($local['locale'])?>)</label>
                                            <input type="text" class="form-control <?=($row==0)?'seodef':''?>" name="locales[<?=$local['id_localization']?>][title]" id="title_<?=$local['iso_1']?>" value="<?= (isset($post['locales'][$local['id_localization']]['title'])) ? $post['locales'][$local['id_localization']]['title'] : '' ?>"/>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div><!-- /.tab content -->
                            </div>
                            <?php endif; ?>
                            <div class="">
                                <label class="control-label" style="display: block;">Page Type</label>
                                <label class="radio-inline">
                                    <input type="radio" name="page_type" class="required" id="static_page" value="1" <?=(isset($post['page_type']) && $post['page_type'] == 1) ? 'checked="checked"' : ''?> /> Static Page
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="page_type" class="required" id="module" value="2" <?=(isset($post['page_type']) && $post['page_type'] == 2) ? 'checked="checked"' : ''?> /> Module
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="page_type" class="required" id="ext_link" value="3" <?=(isset($post['page_type']) && $post['page_type'] == 3) ? 'checked="checked"' : ''?> /> External URL
                                </label>
                            </div>
                            <div class="content-static-page" style="display: none; margin-top: 20px;">
                                <div class="form-group">
                                    <label for="uri_path">SEO URL / SLUG</label>
                                    <input type="text" class="form-control" name="uri_path" id="uri_path" value="<?= (isset($post['uri_path'])) ? $post['uri_path'] : '' ?>"/>
                                </div>
                                <?php if ($locales): ?>
                                <div class="localization" role="tabpanel" id="tabster-content">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <?php foreach ($locales as $row => $local): ?>
                                        <li role="presentation" <?=($row==0) ? 'class="active"' : ''?>>
                                            <a href="#static<?=$local['iso_2'].'-'.$local['id_localization']?>" aria-controls="static<?=$local['iso_2'].'-'.$local['id_localization']?>" role="tab" data-toggle="tab">
                                                <?=ucfirst($local['locale'])?>
                                                <?=($local['locale_status']==1)?' (Default)':''?>
                                            </a>
                                        </li>
                                        <?php endforeach; ?>
                                    </ul><!-- Nav tabs -->
                                    <!-- /.tab content -->
                                    <div class="tab-content">
                                        <?php foreach ($locales as $row => $local): ?>
                                        <div role="tabpanel" class="tab-pane fade <?=($row==0) ? 'in active' : ''?>" id="static<?=$local['iso_2'].'-'.$local['id_localization']?>">
                                            <div class="form-group">
                                                <label for="teaser_<?=$local['iso_1']?>">Teaser (<?=ucfirst($local['locale'])?>)</label>
                                                <textarea class="form-control" rows="4" name="locales[<?=$local['id_localization']?>][teaser]" id="teaser_<?=$local['iso_1']?>"><?= (isset($post['locales'][$local['id_localization']]['teaser'])) ? $post['locales'][$local['id_localization']]['teaser'] : '' ?></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="description_<?=$local['iso_1']?>">Description (<?=ucfirst($local['locale'])?>)</label>
                                                <textarea class="form-control ckeditor" rows="10" name="locales[<?=$local['id_localization']?>][description]" id="description_<?=$local['iso_1']?>"><?= (isset($post['locales'][$local['id_localization']]['description'])) ? $post['locales'][$local['id_localization']]['description'] : '' ?></textarea>
                                            </div>
                                        </div>
                                        <?php endforeach; ?>
                                    </div><!-- /.tab content -->
                                </div>
                                <?php endif; ?>
                            </div>
                            <div class="content-module" style="display: none; margin-top: 20px;">
                                <div class="form-group">
                                    <label for="module">Module</label>
                                    <input type="text" class="form-control" name="module" id="module" value="<?= (isset($post['module'])) ? $post['module'] : '' ?>"/>
                                </div>
                            </div>
                            <div class="content-ext-link" style="display: none; margin-top: 20px;">
                                <div class="form-group">
                                    <label for="ext_link">External URL</label>
                                    <input type="text" class="form-control" name="ext_link" id="ext_link" placeholder="with http://" value="<?= (isset($post['ext_link'])) ? $post['ext_link'] : '' ?>"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="position">Position</label>
                                <input type="number" class="form-control" min="1" name="position" id="position" value="<?= (isset($post['position'])) ? $post['position'] : $max_position ?>"/>
                            </div>
                            <div class="form-group">
                                <label for="id_status">Status</label>
                                <select name="id_status" id="id_status" class="form-control">
                                    <?php foreach ($statuses as $row => $status): ?>
                                    <option value="<?=$status['id_status']?>" <?=(isset($post['id_status']) && $post['id_status'] == $status['id_status'])?'selected="selected"':''?>><?=$status['status_text']?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="is_featured">Featured</label>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" value="1" name="is_featured" id="is_featured" <?= (isset($post['is_featured']) && !empty($post['is_featured'])) ? 'checked="checked"' : '' ?>/>Yes
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="is_header">Show in Header</label>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" value="1" name="is_header" id="is_header" <?= (isset($post['is_header']) && !empty($post['is_header'])) ? 'checked="checked"' : '' ?>/>Yes
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="is_footer">Show in Footer</label>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" value="1" name="is_footer" id="is_footer" <?= (isset($post['is_footer']) && !empty($post['is_footer'])) ? 'checked="checked"' : '' ?>/>Yes
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="thumbnail_image">Thumbnail Image</label>
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail fileinput-upload" style="width: 200px; height: 150px;">
                                        <?php if (isset($post['thumbnail_image']) && $post['thumbnail_image'] != '' && file_exists(UPLOAD_DIR.'pages/'.$post['thumbnail_image'])): ?>
                                            <img src="<?=RELATIVE_UPLOAD_DIR.'pages/tmb_'.$post['thumbnail_image']?>" id="post-image-thumbnail" />
                                            <span class="btn btn-danger btn-delete-photo delete-picture" id="delete-picture" data-id="<?=$post['id_page']?>" data-type="thumbnail">x</span>
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
                                        <?php if (isset($post['primary_image']) && $post['primary_image'] != '' && file_exists(UPLOAD_DIR.'pages/'.$post['primary_image'])): ?>
                                            <img src="<?=RELATIVE_UPLOAD_DIR.'pages/tmb_'.$post['primary_image']?>" id="post-image-primary" />
                                            <span class="btn btn-danger btn-delete-photo delete-picture" id="delete-picture" data-id="<?=$post['id_page']?>" data-type="primary">x</span>
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
                                        <?php if (isset($post['background_image']) && $post['background_image'] != '' && file_exists(UPLOAD_DIR.'pages/'.$post['background_image'])): ?>
                                            <img src="<?=RELATIVE_UPLOAD_DIR.'pages/tmb_'.$post['background_image']?>" id="post-image-primary" />
                                            <span class="btn btn-danger btn-delete-photo delete-picture" id="delete-picture" data-id="<?=$post['id_page']?>" data-type="background">x</span>
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
                    <div class="row" style="margin-top:50px;">
                        <div class="col-lg-4 col-lg-offset-8">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a class="btn btn-danger" href="<?=$cancel_url?>">Cancel</a>
                        </div>
                    </div>
                    <!-- /.row (nested) -->
                <?php echo form_close(); ?>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>

<script type="text/javascript">
    $(function() {
        <?php if (isset($post['id_page'])): ?>
        $(".delete-picture").click(function() {
            var self = $(this);
            var id = self.attr('data-id');
            var type = self.attr('data-type');
            var data = [{name:"id",value:id},{name:"type",value:type}];
            submit_ajax('<?=$delete_picture_url?>',data,self)
                .done(function(data) {
                    console.log(data);
                    if (data['error'])  {
                        $(".flash-message").html(data['error']);
                    }
                    if (data['success']) {
                        $(".flash-message").html(data['success']);
                        $("#post-image-"+type).remove();
                        self.remove();
                    }
                });
        });
        <?php else: ?>
        $(".seodef").keyup(function() {
            $("#uri_path").val(convert_to_uri(this.value));
        });
        <?php endif; ?>
        $(function() {
            $('#form-pages').on('change','input[name=page_type]',function() {
                var self = $(this);
                // static page
                if (self.val() == 1) {
                    $('.content-module, .content-ext-link').slideUp('fast',function() {
                        $(".content-static-page").delay(500).slideDown('slow');
                    });
                } else if (self.val() == 2) {
                    $('.content-static-page, .content-ext-link').slideUp('fast',function() {
                        $(".content-module").delay(500).slideDown('slow');
                    });
                } else if (self.val() == 3) {
                    $('.content-static-page, .content-module').slideUp('fast',function() {
                        $(".content-ext-link").delay(500).slideDown('slow');
                    });
                } else {
                    $('.content-static-page, .content-module, .content-ext-link').hide();
                }
            });
            $('input[name=page_type]:checked').trigger('change');
        });
    });
</script>
