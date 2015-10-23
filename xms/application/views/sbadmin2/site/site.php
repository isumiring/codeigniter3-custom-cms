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
            <th data-name="site_name">Site Name</th>
            <th data-name="site_url">Site URL</th>
            <th data-name="is_default" data-searchable="false">Default</th>
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
<script type="text/javascript">
    list_dataTables('#dataTables-list','<?= $url_data ?>');
</script>
