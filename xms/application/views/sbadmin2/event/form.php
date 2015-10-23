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
                <?php echo form_open($form_action,'role="form" enctype="multipart/form-data"'); ?>
                    <div class="row">
                        <div class="col-lg-8">
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
                                        <div class="form-group">
                                            <label for="teaser_<?=$local['iso_1']?>">Teaser (<?=ucfirst($local['locale'])?>)</label>
                                            <textarea class="form-control" rows="10" name="locales[<?=$local['id_localization']?>][teaser]" id="teaser_<?=$local['iso_1']?>"><?= (isset($post['locales'][$local['id_localization']]['teaser'])) ? $post['locales'][$local['id_localization']]['teaser'] : '' ?></textarea>
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
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="uri_path">SEO URL / SLUG</label>
                                <input type="text" class="form-control" name="uri_path" id="uri_path" value="<?= (isset($post['uri_path'])) ? $post['uri_path'] : '' ?>"/>
                            </div>
                            <div class="form-group">
                                <label for="id_status">Status</label>
                                <select name="id_status" id="id_status" class="form-control">
                                    <?php foreach ($statuses as $row => $status): ?>
                                    <option value="<?=$status['id_status']?>" <?=(isset($post['id_status']) && $post['id_status'] == $status['id_status'])?'selected="selected"':''?>><?=$status['status_text']?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="is_featured" id="is_featured" value="1" <?=(isset($post['is_featured']) && $post['is_featured'] != '')?> /> Featured
                                </label>
                            </div>
                            <div class="form-group">
                                <label for="publish_date">Publish Date</label>
                                <div class="input-group date">
                                    <input type="text" class="form-control" name="publish_date" id="publish_date" value="<?= (isset($post['publish_date'])) ? $post['publish_date'] : date('Y-m-d') ?>" readonly="readonly"/>
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="start_date">Start</label>
                                <div class="input-group datetime datetimepicker" id="start_date_time">
                                    <input type="text" class="form-control" name="start_date" id="start_date" value="<?= (isset($post['start_date'])) ? $post['start_date'] : '' ?>" readonly="readonly" />
                                    <span class="input-group-addon start_date"><i class="glyphicon glyphicon-calendar"></i></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="end_date">End</label>
                                <div class="input-group datetime datetimepicker" id="end_date_time">
                                    <input type="text" class="form-control" name="end_date" id="end_date" value="<?= (isset($post['end_date'])) ? $post['end_date'] : '' ?>" readonly="readonly"/>
                                    <span class="input-group-addon end_date"><i class="glyphicon glyphicon-calendar"></i></span>
                                </div>
                                <label>
                                    <input type="checkbox" value="1" name="one_day" id="one_day" <?= ( (isset($post['one_day']) && !empty($post['one_day'])) || ( (empty($post['end_date']) || $post['end_date'] == '0000-00-00' || $post['end_date'] == '1970-01-01')) ) ? 'checked="checked"' : '' ?>/> One Day
                                </label>
                            </div>
                            <div class="form-group">
                                <label for="thumbnail_image">Thumbnail Image</label>
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail fileinput-upload" style="width: 200px; height: 150px;">
                                        <?php if (isset($post['thumbnail_image']) && $post['thumbnail_image'] != '' && file_exists(UPLOAD_DIR.'article/'.$post['thumbnail_image'])): ?>
                                            <img src="<?=RELATIVE_UPLOAD_DIR.'article/tmb_'.$post['thumbnail_image']?>" id="post-image-thumbnail" />
                                            <span class="btn btn-danger btn-delete-photo delete-picture" id="delete-picture" data-id="<?=$post['id_article']?>" data-type="thumbnail">x</span>
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
                                        <?php if (isset($post['primary_image']) && $post['primary_image'] != '' && file_exists(UPLOAD_DIR.'article/'.$post['primary_image'])): ?>
                                            <img src="<?=RELATIVE_UPLOAD_DIR.'article/tmb_'.$post['primary_image']?>" id="post-image-primary" />
                                            <span class="btn btn-danger btn-delete-photo delete-picture" id="delete-picture" data-id="<?=$post['id_article']?>" data-type="primary">x</span>
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
        $("#one_day").change(function() {
            var self = $(this);
            if (self.prop('checked') == true) {
                $("#end_date").attr('disabled',true);
                $("#end_date").val('');
                $(".input-group-addon.end_date").addClass('blocked');
            } else {
                $("#end_date").removeAttr('disabled');
                $(".input-group-addon.end_date").removeClass('blocked');
            }
        });
        $("#one_day").trigger('change');
        <?php if (isset($post['id_article'])): ?>
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
    });
</script>
