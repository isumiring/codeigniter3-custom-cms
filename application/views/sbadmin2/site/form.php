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
                <?=$page_title?> 
            </div>
            <div class="panel-body">
                <?php echo form_open($form_action,'role="form" enctype="multipart/form-data"'); ?>
                    <div role="tabpanel" id="tabster">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#info" aria-controls="info" role="tab" data-toggle="tab">Site Info</a></li>
                            <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Site Settings</a></li>
                        </ul><!-- Nav tabs -->
                        <!-- /*tab content/ -->
                        <div class="tab-content">
                            <!-- /* info -->
                            <div role="tabpanel" class="tab-pane fade in active" id="info">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="site_name">Site Name</label>
                                            <input type="text" class="form-control" name="site_name" id="site_name" value="<?=(isset($post['site_name'])) ? $post['site_name'] : ''?>"/>
                                        </div>
                                        <div class="form-group">
                                            <label for="site_url">Site URL</label>
                                            <input type="text" class="form-control" name="site_url" id="site_url" value="<?=(isset($post['site_url'])) ? $post['site_url'] : ''?>"/>
                                        </div>
                                        <div class="form-group">
                                            <label for="site_path">Site Path</label>
                                            <input type="text" class="form-control" name="site_path" id="site_path" value="<?=(isset($post['site_path'])) ? $post['site_path'] : ''?>"/>
                                        </div>
                                        <div class="form-group">
                                            <label for="site_address">Address</label>
                                            <textarea class="form-control" name="site_address" id="site_address"><?=(isset($post['site_address'])) ? $post['site_address'] : ''?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-lg-offset-2">
                                        <div class="form-group">
                                            <label for="is_default">Default</label>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" value="1" name="is_default" id="is_default" <?=(isset($post['is_default']) && !empty($post['is_default'])) ? 'checked="checked"' : ''?>/>Default
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="image">Logo</label>
                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail fileinput-upload" style="width: 200px; height: 150px;">
                                                    <?php if (isset($post['site_logo']) && $post['site_logo'] != '' && file_exists(UPLOAD_DIR.'site/'.$post['site_logo'])): ?>
                                                        <img src="<?=RELATIVE_UPLOAD_DIR.'site/'.$post['site_logo']?>" id="post-image" />
                                                        <span class="btn btn-danger btn-delete-photo" id="delete-picture" data-id="<?=$post['id_site']?>">x</span>
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
                            </div><!-- /* info -->
                            <!-- /#settings -->
                            <div role="tabpanel" class="tab-pane fade" id="settings">
                                <div class="row">
                                    <?php foreach ($post['setting'] as $row => $setting): ?>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="<?=$row?>"><?=ucwords(str_replace('_',' ',$row))?></label>
                                                <textarea class="form-control" name="setting[<?=$row?>]" id="<?=$row?>" rows="1"><?=$setting?></textarea>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div><!-- /#settings -->
                        </div><!-- /*tab content/ -->
                        <div class="row">
                            <div class="col-lg-4 col-lg-offset-8">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a class="btn btn-danger" href="<?=$cancel_url?>">Cancel</a>
                            </div>
                        </div>
                        <!-- /.row (nested) -->
                    </div>
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
        <?php if (isset($post['id_site'])): ?>
        $("#delete-picture").click(function() {
            var self = $(this);
            var id = self.attr('data-id');
            var post_delete = [{name:"id",value:id}];
            post_delete.push({name:token_name,value:token_key});
            $.ajax({
                url:'<?=$delete_picture_url?>',
                type:'post',
                data:post_delete,
                dataType:'json',
                beforeSend: function() {
                    self.attr('disabled',true);
                }
            }).always(function() {
                self.removeAttr('disabled');
            }).done(function(data) {
                if (data['error'])  {
                    $('.flash-message').html(data['error']);
                }
                if (data['success']) {
                    $('.flash-message').html(data['success']);
                    $("#post-image").remove();
                    self.remove();
                }
            });
        });
        <?php endif; ?>
    });
</script>