
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
                <form role="form" action="<?=$form_action?>" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="username">Username:</label>
                                <strong><?=$post['username']?></strong>
                            </div>
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input class="form-control" name="name" id="name" value="<?=(isset($post['name'])) ? $post['name'] : ''?>"/>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input class="form-control" name="email" id="name" value="<?=(isset($post['email'])) ? $post['email'] : ''?>"/>
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea class="form-control" rows="3" id="address" name="address"><?=(isset($post['address'])) ? $post['address'] : ''?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input class="form-control" name="phone" id="phone" value="<?=(isset($post['phone'])) ? $post['phone'] : ''?>"/>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-info" id="change_pass" type="button" data-toggle="modal" data-target="#passModal">Change Password</button>
                            </div>
                        </div>
                        <div class="col-lg-4 col-lg-offset-2">
                            <div class="form-group">
                                <label for="image">Image</label>
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                        <?php if ($post['image'] != '' && file_exists(UPLOAD_DIR.'admin/'.$post['image'])): ?>
                                            <img src="<?=RELATIVE_UPLOAD_DIR.'admin/'.$post['image']?>" />
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
                        </div>
                    </div>
                    <!-- /.row (nested) -->
                </form>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- Modal -->
<div class="modal fade" id="passModal" tabindex="-1" role="dialog" aria-labelledby="passModalLabel" aria-hidden="true">
    <!-- Modal Dialog -->
    <div class="modal-dialog">
        <!-- Modal Content -->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                Change Password
            </div>
            <div class="modal-body">
                <form action="<?= $changepass_form ?>" method="post" id="change_pass_form" onsubmit="return false;">
                    <div id="print-msg" class="error"></div>
                    <div class="form-group">
                        <label for="old_password" class="control-label">Old Password:</label>
                        <input type="password" id="old_password" class="form-control" name="old_password" value=""/>
                    </div>
                    <div class="form-group">
                        <label for="new_password" class="control-label">New Password:</label>
                        <input type="password" id="new_password" class="form-control" name="new_password" value=""/>
                    </div>
                    <div class="form-group">
                        <label for="conf_password" class="control-label">Confirm New Password:</label>
                        <input type="password" id="conf_password" class="form-control" name="conf_password" value=""/>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="save_password">Save changes</button>
                <button class="btn btn-warning" data-dismiss="modal" aria-hidden="true">Close</button>
            </div>
        </div><!-- Modal Content -->
    </div><!-- Modal Dialog -->
</div><!-- Modal -->
<script type="text/javascript">
    $("#save_password").click(function() {
        $("#print-msg").html('');
        var old_password = $("#old_password").val();
        var new_password = $("#new_password").val();
        var conf_password = $("#conf_password").val();
        if (old_password != '') {
            if (new_password != '' && (conf_password == new_password)) {
                $.ajax({
                    url:'<?=$changepass_form?>',
                    type:'post',
                    dataType:'json',
                    data:$('#change_pass_form').serialize(),
                    beforeSend:function() {
                        $('button').attr('disabled','disabled');
                    }
                }).always(function() {
                    $('button').removeAttr('disabled');
                }).done(function(data) {
                    if (data['location']) {
                        window.location = data['location'];
                        return;
                    }
                    if (data['error']) {
                        $("#print-msg").html(data['error']);
                    }
                    if (data['success']) {
                        $("#print-msg").html(data['success']);
                        setTimeout(function() {
                            if (data['redirect']) {
                                window.location = data['redirect'];
                            }
                        }, 2000);
                    }
                });
            } else {
                $("#print-msg").html('Please input Your New Password or Confirmation is not correct.<br/>');
            }
        } else {
            $("#print-msg").html('Please input Your old password.<br/>');
        }
    });
</script>