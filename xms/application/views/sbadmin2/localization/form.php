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
                <?php echo form_open($form_action, 'role="form"'); ?>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="locale">Locale/Language <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="locale" id="locale" value="<?php echo (isset($post['locale'])) ? $post['locale'] : ''; ?>" required="required"/>
                            </div>
                            <div class="form-group">
                                <label for="iso_1">ISO 2 <span class="text-danger">*</span></label>
                                <input type="text" maxlength="4" class="form-control" name="iso_1" id="iso_1" value="<?php echo (isset($post['iso_1'])) ? $post['iso_1'] : ''; ?>" required="required"/>
                            </div>
                            <div class="form-group">
                                <label for="iso_2">ISO 3 <span class="text-danger">*</span></label>
                                <input type="text" maxlength="4" class="form-control" name="iso_2" id="iso_2" value="<?php echo (isset($post['iso_2'])) ? $post['iso_2'] : ''; ?>" required="required"/>
                            </div>
                            <div class="form-group">
                                <label for="locale_path">Path <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="locale_path" id="locale_path" value="<?php echo (isset($post['locale_path'])) ? $post['locale_path'] : ''; ?>" required="required"/>
                            </div>
                        </div>
                        <div class="col-lg-4 col-lg-offset-2">
                            <div class="form-group">
                                <label for="locale_status">Status</label>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" value="1" name="locale_status" id="locale_status" <?php echo (isset($post['locale_status']) && ! empty($post['locale_status'])) ? 'checked="checked"' : ''; ?>/> Default
                                    </label>
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
