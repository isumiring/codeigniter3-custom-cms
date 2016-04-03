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
                <?php echo $page_title; ?> Form
            </div>
            <div class="panel-body">
                <?php echo form_open($form_action, 'role="form" enctype="multipart/form-data"'); ?>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="username">Username <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="username" id="username" value="<?php echo (isset($post['username'])) ? $post['username'] : ''; ?>" required="required"/>
                            </div>
                            <div class="form-group">
                                <label for="id_auth_group">Group <span class="text-danger">*</span></label>
                                <select class="form-control" name="id_auth_group" id="id_auth_group" required="required">
                                    <?php foreach ($groups as $group) : ?>
                                    <option value="<?php echo $group['id_auth_group']; ?>" <?php echo (isset($post['id_auth_group']) && $group['id_auth_group'] == $post['id_auth_group']) ? 'selected="selected"' : ''; ?>>
                                        <?php echo $group['auth_group']; ?>
                                    </option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="password">Password  <span class="text-danger">*</span></label>
                                <input type="password" id="password" class="form-control" name="password" value=""/>
                                <?php if (isset($post['id_auth_user'])): ?>
                                <p class="help-block"><small>Leave this field empty if You don't want to change the password.</small></p>
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <label for="conf_password">Password Confirmation <span class="text-danger">*</span></label>
                                <input type="password" id="conf_password" class="form-control" name="conf_password" value=""/>
                            </div>
                            <div class="form-group">
                                <label for="name">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name" id="name" value="<?php echo (isset($post['name'])) ? $post['name'] : ''; ?>" required="required"/>
                            </div>
                            <div class="form-group">
                                <label for="email">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="email" id="name" value="<?php echo (isset($post['email'])) ? $post['email'] : ''; ?>" required="required"/>
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea class="form-control" rows="3" id="address" name="address"><?php echo (isset($post['address'])) ? $post['address'] : ''; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="text" class="form-control" name="phone" id="phone" value="<?php echo (isset($post['phone'])) ? $post['phone'] : ''; ?>"/>
                            </div>
                        </div>
                        <div class="col-lg-4 col-lg-offset-2">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" value="1" name="status" id="status" <?php echo (isset($post['status']) && !empty($post['status'])) ? 'checked="checked"' : ''; ?>/>Active
                                    </label>
                                </div>
                            </div>
                            <?php if (is_superadmin()) : ?>
                            <div class="form-group">
                                <label for="is_superadmin">Super Administrator</label>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" value="1" name="is_superadmin" id="is_superadmin" <?php echo (isset($post['is_superadmin']) && !empty($post['is_superadmin'])) ? 'checked="checked"' : ''; ?>/>Yes
                                    </label>
                                </div>
                            </div>
                            <?php endif; ?>
                            <div class="form-group">
                                <label for="themes">Themes</label>
                                <select class="form-control" name="themes" id="themes">
                                    <option value="sbadmin2">SBADMIN 2</option>
                                </select>
                                <p class="help-block"><small>You have to logout first before changing new themes.</small></p>
                            </div>
                            <div class="form-group">
                                <label for="image">Image</label>
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail fileinput-upload" style="width: 200px; height: 150px;">
                                        <?php if (isset($post['image']) && $post['image'] != '' && file_exists(UPLOAD_DIR. $this->router->fetch_class() . '/'.$post['image'])): ?>
                                            <img src="<?php echo RELATIVE_UPLOAD_DIR. $this->router->fetch_class(). '/tmb_'.$post['image']; ?>" id="post-image" />
                                            <span class="btn btn-danger btn-delete-photo" id="delete-picture" data-id="<?php echo $post['id_auth_user']; ?>">x</span>
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
                            <a class="btn btn-danger" href="<?php echo $cancel_url; ?>">Cancel</a>
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
            $('.flash-message').empty();
            var self = $(this);
            var id = self.attr('data-id');
            var post_delete = [
                {'name': 'id', 'value': id}
            ];
            submit_ajax('<?php echo $delete_picture_url; ?>', post_delete, self)
                .done(function(data) {
                    if (data['error'])  {
                        $(".flash-message").html(data['error']);
                    }
                    if (data['success']) {
                        $(".flash-message").html(data['success']);
                        $("#post-image").remove();
                        self.remove();
                    }
                });
        });
        <?php endif; ?>
    });
</script>