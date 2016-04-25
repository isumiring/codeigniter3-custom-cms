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
                        <th data-name="title">Title</th>
                        <th data-name="location">Location</th>
                        <th data-name="start_date" data-searchable="false">Date</th>
                        <th data-name="publish_date" data-searchable="false">Published</th>
                        <th data-name="status_text">Status</th>
                        <th data-name="create_date" data-searchable="false">Create Date</th>
                    </tr>
                </thead>
            </table>

            <br/><br/>
            <input type="hidden" id="delete-record-field"/>
            <div class="row">
                <div class="col-md-4 col-md-offset-8 text-right">
                    <a href="<?php echo $add_url; ?>" class="btn btn-success">Add</a>
                    <button type="button" class="btn btn-danger" id="delete-record">Delete</button>
                </div>
            </div>
        </div>
        <!--/.box-dttables-->
    </div>
</div>
<!--/.row-->
<br/><br/>
<script type="text/javascript">
    list_dataTables('#dataTables-list','<?php echo $url_data; ?>');
</script>
