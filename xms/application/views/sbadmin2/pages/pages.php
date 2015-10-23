<div class="row top-cursor">
    <div class="col-md-4 col-md-offset-8 text-right">
        <a href="<?=$add_url?>" class="btn btn-success">Add</a>
        <button type="button" class="btn btn-danger delete-record" id="delete-record">Delete</button>
    </div>
</div>
<table class="table table-striped table-bordered table-hover" id="dataTables-list">
    <thead>
        <tr>
            <th data-searchable="false" data-orderable="false" data-name="actions" data-classname="text-center"></th>
            <th data-name="page_name">Page Name</th>
            <th data-name="parent_page_name" data-searchable="false">Parent</th>
            <th data-name="url_link" data-searchable="false" data-orderable="false">Path</th>
            <th data-name="status_text">Status</th>
            <th data-searchable="false" data-name="position">Position</th>
            <th data-name="create_date" data-searchable="false">Create Date</th>
        </tr>
    </thead>
</table>

<br/><br/>
<input type="hidden" id="delete-record-field"/>
<div class="row">
    <div class="col-md-4 col-md-offset-8 text-right">
        <a href="<?=$add_url?>" class="btn btn-success">Add</a>
        <button type="button" class="btn btn-danger delete-record" id="delete-record">Delete</button>
    </div>
</div>
<br/><br/>
<script type="text/javascript">
    list_dataTables('#dataTables-list','<?= $url_data ?>');
</script>
