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
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" name="username" id="username" value="<?=(isset($post['username'])) ? $post['username'] : ''?>"/>
                            </div>
                            <div class="form-group">
                                <label for="id_auth_group">Group</label>
                                <select class="form-control" name="id_auth_group" id="id_auth_group">
                                    <?php
                                        foreach($groups as $group) {
                                            if (isset($post['id_auth_group']) && $group['id_auth_group'] == $post['id_auth_group']) {
                                                echo '<option value="'.$group['id_auth_group'].'" selected="selected">'.$group['auth_group'].'</option>';
                                            } else {
                                                echo '<option value="'.$group['id_auth_group'].'">'.$group['auth_group'].'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="password">Password </label>
                                <input type="password" id="password" class="form-control" name="password" value=""/>
                                <?php if (isset($post['id_auth_user'])): ?>
                                <p class="help-block"><small>Leave this field empty if You don't want to change Your password.</small></p>
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <label for="conf_password">Password Confirmation</label>
                                <input type="password" id="conf_password" class="form-control" name="conf_password" value=""/>
                            </div>
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" name="name" id="name" value="<?=(isset($post['name'])) ? $post['name'] : ''?>"/>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" id="name" value="<?=(isset($post['email'])) ? $post['email'] : ''?>"/>
                            </div>
                            <div class="form-group">
                                <label for="alamat">Address</label>
                                <textarea class="form-control" rows="3" id="alamat" name="alamat"><?=(isset($post['alamat'])) ? $post['alamat'] : ''?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="text" class="form-control" name="phone" id="phone" value="<?=(isset($post['phone'])) ? $post['phone'] : ''?>"/>
                            </div>
                        </div>
                        <div class="col-lg-4 col-lg-offset-2">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" value="1" name="status" id="status" <?=(isset($post['status']) && !empty($post['status'])) ? 'checked="checked"' : ''?>/>Active
                                    </label>
                                </div>
                            </div>
                            <?php if (is_superadmin()) : ?>
                            <div class="form-group">
                                <label for="is_superadmin">Super Administrator</label>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" value="1" name="is_superadmin" id="is_superadmin" <?=(isset($post['is_superadmin']) && !empty($post['is_superadmin'])) ? 'checked="checked"' : ''?>/>Yes
                                    </label>
                                </div>
                            </div>
                            <?php endif; ?>
                            <div class="form-group">
                                <label for="image">Image</label>
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                        <?php if (isset($post['image']) && $post['image'] != '' && file_exists(UPLOAD_DIR.'admin/'.$post['image'])): ?>
                                            <img src="<?=RELATIVE_UPLOAD_DIR.'admin/'.$post['image']?>" id="post-image" />
                                            <span class="btn btn-delete-photo" id="delete-picture" data-id="<?=$post['id_auth_user']?>">Delete</span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
                                    <div>
                                        <span class="btn btn-default btn-file">
                                            <span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span>
                                            <input type="file" name="image">
                                        </span>
                                        <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
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
        <?php if (isset($post['id_auth_user'])): ?>
        $("#delete-picture").click(function() {
            var self = $(this);
            var id = self.attr('data-id');
            $.ajax({
                url:'<?=$delete_picture_url?>',
                type:'post',
                data:'id='+id,
                dataType:'json',
                beforeSend: function() {
                    self.attr('disabled',true);
                }
            }).always(function() {
                self.removeAttr('disabled');
            }).done(function(data) {
                if (data['error'])  {
                    alert(data['error']);
                }
                if (data['success']) {
                    alert(data['success']);
                    $("#post-image").remove();
                    self.remove();
                }
            });
        });
        <?php endif; ?>
    });
</script>