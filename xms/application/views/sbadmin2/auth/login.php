
<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <?php if ($site_info['site_logo'] != '' && file_exists(UPLOAD_DIR.'site/'.$site_info['site_logo'])) : ?>
            <img src="<?php echo RELATIVE_UPLOAD_DIR.'site/'.$site_info['site_logo']; ?>" alt="Main Logo" class="img-responsive img-sitelogo"/>
        <?php endif; ?>
        <div class="login-panel panel panel-default animated fadeInDownBig">
            <div class="panel-heading">
                <h3 class="panel-title">Please Sign In</h3>
            </div>
            <div class="panel-body">
                <div class="form-message">
                    <?php if (isset($error_login)) {
    echo $error_login;
} ?>
                </div>
                <?php echo form_open($form_action, 'role="form" onsubmit="return false;" id="form-login-auth"'); ?>
                    <fieldset>
                        <div class="form-group animated fadeInLeftBig">
                            <input class="form-control" placeholder="Username" name="username" type="text" autofocus>
                        </div>
                        <div class="form-group animated fadeInRightBig">
                            <input class="form-control" placeholder="Password" name="password" type="password" value="">
                        </div>
                        <!-- Change this to a button or input when using this as a form -->
                        <button type="submit" class="btn btn-lg btn-success btn-block" id="go-login">Login</button>
                    </fieldset>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>

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