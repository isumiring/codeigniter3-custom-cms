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

        <?php echo form_open($form_action, 'role="form"'); ?>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="auth_group">Group Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="auth_group" id="auth_group" value="<?php echo (isset($post['auth_group'])) ? $post['auth_group'] : ''; ?>" required="required"/>
                    </div>
                </div>
                <div class="col-md-4">
                    <?php if (is_superadmin()): ?>
                    <div class="form-group">
                        <label for="is_superadmin">Super Administrator</label>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" class="iCheckBox" value="1" name="is_superadmin" id="is_superadmin" <?php echo (isset($post['is_superadmin']) && !empty($post['is_superadmin'])) ? 'checked="checked"' : ''; ?>/> Yes
                            </label>
                        </div>
                    </div>
                    <?php endif; ?>
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
