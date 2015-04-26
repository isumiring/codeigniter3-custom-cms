
<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <div class="login-panel panel panel-default animated fadeInDownBig">
            <div class="panel-heading">
                <h3 class="panel-title">Please Sign In</h3>
            </div>
            <div class="panel-body">
                <?php
                if (isset($error_login)) {
                    echo $error_login;
                }
                ?>
                <?php echo form_open($form_action,'role="form"'); ?>
                    <fieldset>
                        <div class="form-group animated fadeInLeftBig">
                            <input class="form-control" placeholder="Username" name="username" type="text" autofocus>
                        </div>
                        <div class="form-group animated fadeInRightBig">
                            <input class="form-control" placeholder="Password" name="password" type="password" value="">
                        </div>
                        <!-- Change this to a button or input when using this as a form -->
                        <button type="submit" class="btn btn-lg btn-success btn-block">Login</button>
                    </fieldset>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
