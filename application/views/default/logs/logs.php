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

<script type="text/javascript">
    var columns = [
        { 'data':'username' }, 
        { 'data':'email' }, 
        { 'data':'auth_group' }, 
        { 'data':'action' }, 
        { 'data':'desc','searchable':false,'sortable':false }, 
        { 'data':'created','searchable':false }
    ];
    list_dataTables('#dataTables-list','<?= $url_data ?>',columns);
</script>
