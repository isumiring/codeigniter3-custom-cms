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
                <?=$page_title?>
            </div>
            <div class="panel-body">
                <?php echo form_open($form_action,'role="form"'); ?>
                    <div class="row">
                        <div class="col-lg-6">
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
                        <div class="col-lg-6">
                            <div class="form-group">
                                <?=$auth_menu_html?>
                            </div>
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

<script type="text/javascript">
    $(function() {
        $('#select-all').on('click', function () {
            $(this).closest('form').find(':checkbox').prop('checked', this.checked);
        });
        $(".checkauth").on('click', function() {
            if ($('.checkauth:checked').length == $('.checkauth').length) {
                $("#select-all").prop('checked', true);
            } else {
                $("#select-all").prop('checked', false);
            }
        });
        if ($('.checkauth:checked').length == $('.checkauth').length) {
            $("#select-all").attr('checked', 'checked');
        }
    });
</script>
