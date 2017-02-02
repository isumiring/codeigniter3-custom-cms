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
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" value="1" id="select-all"/> <label for="select-all">Select All</label>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <hr/>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <?php echo $auth_menu_html; ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-left">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a class="btn btn-danger" href="<?php echo $cancel_url; ?>">Cancel</a>
                </div>
            </div>
            <!-- /.row (nested) -->
        <?php echo form_close(); ?>
    </div>
    <!-- /.box-body -->
</div>
<!--/.box-->

<script type="text/javascript">
    $(function() {
        $('#select-all').on('ifClicked', function (e) {
            $(this).on('ifChecked', function() {
                $('.checkauth').iCheck('check');
            });
            $(this).on('ifUnchecked', function() {
                $('.checkauth').iCheck('uncheck');
            });
        });
        $('.checkauth').on('ifChecked', function(e) {
            if ($('.checkauth:checked').length == $('.checkauth').length) {
                $('#select-all').iCheck('check');
            }
        });
        $('.checkauth').on('ifUnchecked', function(e) {
            $('#select-all').iCheck('uncheck');
        });
        if ($('.checkauth:checked').length == $('.checkauth').length) {
            $('#select-all').iCheck('check');
        }
    });
</script>
