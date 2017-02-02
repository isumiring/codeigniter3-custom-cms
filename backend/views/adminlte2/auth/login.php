
<div class="login-box">
    <?php if ($site_info['site_logo'] != '' && file_exists(UPLOAD_DIR.'site/'.$site_info['site_logo'])) : ?>
    <div class="login-logo">
        <img src="<?php echo RELATIVE_UPLOAD_DIR .'site/'. $site_info['site_logo']; ?>" alt="Main Logo" class="img-responsive img-sitelogo"/>
    </div>
    <!-- /.login-logo -->
    <?php endif; ?>
    <div class="login-box-body">
        <p class="login-box-msg">Hey! Let's go to work.</p>
        <?php echo form_open($form_action, 'role="form" onsubmit="return false;" id="form-login-auth"'); ?>
            <div class="form-message">
                <?php if (isset($error_login)) {
                    echo $error_login;
                } ?>
            </div>
            <div class="form-group has-feedback animated fadeInLeftBig">
                <input type="text" class="form-control" placeholder="Username" name="username" required="required" value="" autofocus/>
                <span class="fa fa-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback animated fadeInRightBig">
                <input type="password" class="form-control" placeholder="Password" name="password" required="required" value=""/>
                <span class="fa fa-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-4 col-xs-offset-8">
                    <button type="submit" class="btn btn-primary btn-block btn-flat" id="go-login">Sign In</button>
                </div><!-- /.col -->
            </div>
        <?php echo form_close(); ?>
        <!--/#form-login-auth-->
    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<script type="text/javascript">
    $(function() {
        $('#go-login').on('click', function() {
            $('.form-message').empty();
            var self = $(this),
                self_html = $(this).html();
            var data = $('#form-login-auth').serializeArray();
            if (typeof data != 'undefined' && data != '') {
                submit_ajax('<?php echo $form_action; ?>', data, self)
                    .always(function() {
                        self.html(self_html).removeAttr('disabled');
                    })
                    .done(function(response) {
                        if (response['status'] && response['status'] == 'failed') {
                            $('.form-message').html(response['message']);
                        }
                    });
            }
        })
    })
</script>
