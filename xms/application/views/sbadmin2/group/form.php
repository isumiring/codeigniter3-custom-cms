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
                <?php echo form_open($form_action,'role="form"'); ?>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="auth_group">Group Name</label>
                                <input type="text" class="form-control" name="auth_group" id="auth_group" value="<?=(isset($post['auth_group'])) ? $post['auth_group'] : ''?>"/>
                            </div>
                        </div>
                        <div class="col-lg-4 col-lg-offset-2">
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
