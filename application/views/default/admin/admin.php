<table class="table table-striped table-bordered table-hover" id="dataTables-list">
    <thead>
        <tr>
            <th></th>
            <th>Username</th>
            <th>Name</th>
            <th>Email</th>
            <th>Group</th>
            <th class="default_sort">Create Date</th>
        </tr>
    </thead>
</table>

<input type="hidden" id="delete-record-field"/>
<div class="row">
    <div class="col-md-2 col-md-offset-10">
        <button type="button" class="btn btn-danger btn-block" id="delete-record">Delete</button>
    </div>
</div>
<br/><br/>
<script type="text/javascript">
    var columns = <?=json_encode($data_field)?>;
    list_dataTables('#dataTables-list','<?= $url_data ?>',columns);
</script>