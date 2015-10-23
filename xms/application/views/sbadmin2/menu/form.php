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
                                <label for="parent_auth_menu">Parent</label>
                                <select class="form-control" name="parent_auth_menu" id="parent_auth_menu">
                                    <option value="0">ROOT</option>
                                    <?=$auth_menu_html?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="menu">Menu</label>
                                <input type="text" class="form-control" name="menu" id="menu" value="<?=(isset($post['menu'])) ? $post['menu'] : ''?>"/>
                            </div>
                            <div class="form-group">
                                <label for="file">File Path</label>
                                <input type="text" class="form-control" name="file" id="file" value="<?=(isset($post['file'])) ? $post['file'] : ''?>"/>
                            </div>
                            <div class="form-group form-group-sm">
                                <label for="position">Position</label>
                                    <input type="text" class="form-control" name="position" id="position" value="<?=(isset($post['position'])) ? $post['position'] : $max_position?>"/>
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
