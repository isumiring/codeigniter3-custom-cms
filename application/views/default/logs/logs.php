<table class="table table-striped table-bordered table-hover" id="dataTables-list">
    <thead>
        <tr>
            <th>Username</th>
            <th>Email</th>
            <th>Group</th>
            <th>Action</th>
            <th>Desc</th>
            <th class="default_sort">Created</th>
        </tr>
    </thead>
</table>
<br/><br/>
<script type="text/javascript">
    var columns = <?=json_encode($data_field)?>;
    list_dataTables('#dataTables-list','<?= $url_data ?>',columns);
</script>
