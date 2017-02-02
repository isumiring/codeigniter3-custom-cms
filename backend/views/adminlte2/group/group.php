
<div class="row">
    <div class="col-xs-12">
        <div class="box box-dttables box-info">
            <div class="row top-cursor">
                <div class="col-md-4 col-md-offset-8 text-right">
                    <a href="<?php echo $add_url; ?>" class="btn btn-success">Add</a>
                    <button type="button" class="btn btn-danger delete-record" id="delete-record">Delete</button>
                </div>
            </div>
            <table class="table table-striped table-bordered table-hover" id="dataTables-list">
                <thead>
                    <tr>
                        <th data-searchable="false" data-orderable="false" data-name="actions" data-classname="text-center"></th>
                        <th data-name="auth_group">Group Name</th>
                        <th data-name="authorization" data-searchable="false" data-orderable="false" data-classname="text-center">Authorization</th>
                    </tr>
                </thead>
            </table>

            <br/><br/>
            <input type="hidden" id="delete-record-field"/>
            <div class="row">
                <div class="col-md-4 col-md-offset-8 text-right">
                    <a href="<?php echo $add_url; ?>" class="btn btn-success">Add</a>
                    <button type="button" class="btn btn-danger delete-record" id="delete-record">Delete</button>
                </div>
            </div>
        </div>
        <!--/.box-dttables-->
    </div>
</div>
<br/><br/>
<script type="text/javascript">
    list_dataTables('#dataTables-list', '<?php echo $url_data; ?>');
</script>
