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
        <?php echo form_open($form_action,'role="form" enctype="multipart/form-data"'); ?>
            <div class="row">
                <div class="col-md-8">
                    <?php if ($locales): ?>
                    <div class="nav-tabs-custom localization">
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
                                    <input type="text" class="form-control <?php echo ($row == 0) ? 'seodef' : ''?>" name="locales[<?php echo $local['id_localization']; ?>][title]" id="title_<?php echo $local['iso_1']; ?>" value="<?php echo (isset($post['locales'][$local['id_localization']]['title'])) ? $post['locales'][$local['id_localization']]['title'] : ''; ?>"/>
                                </div>
                                <div class="form-group">
                                    <label for="caption_<?php echo $local['iso_1']; ?>">Caption (<?php echo ucfirst($local['locale']); ?>)</label>
                                    <textarea class="form-control editorable" rows="10" name="locales[<?php echo $local['id_localization']; ?>][caption]" id="caption_<?php echo $local['iso_1']; ?>"><?php echo (isset($post['locales'][$local['id_localization']]['caption'])) ? $post['locales'][$local['id_localization']]['caption'] : ''; ?></textarea>
                                </div>
                            </div>
                            <?php endforeach; ?>
                            <!--/.tab-pane-->
                        </div>
                        <!-- /.tab content -->
                    </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="url_link">URL</label>
                        <input type="text" class="form-control" name="url_link" id="url_link" placeholder="with http://" value="<?php echo (isset($post['url_link'])) ? $post['url_link'] : ''; ?>"/>
                    </div>
                    <div class="form-group">
                        <label for="position">Position</label>
                        <input type="number" min="1" step="1" class="form-control" name="position" id="uri_path" value="<?php echo (isset($post['position'])) ? $post['position'] : $max_position; ?>"/>
                    </div>
                    <div class="form-group">
                        <label for="id_status">Status</label>
                        <select name="id_status" id="id_status" class="form-control">
                            <?php foreach ($statuses as $row => $status): ?>
                            <option value="<?php echo $status['id_status']; ?>" <?php echo (isset($post['id_status']) && $post['id_status'] == $status['id_status']) ? 'selected="selected"' : ''; ?>>
                                <?php echo $status['status_text']; ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="primary_image">Image</label>
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="fileinput-new thumbnail fileinput-upload" style="width: 200px; height: 150px;">
                                <?php if (isset($post['primary_image']) && $post['primary_image'] != '' && file_exists(UPLOAD_DIR . $this->router->fetch_class(). '/'. $post['primary_image'])): ?>
                                    <img src="<?php echo RELATIVE_UPLOAD_DIR . $this->router->fetch_class(). '/'. $post['primary_image']; ?>" id="post-image" />
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

