<table class="table table-striped table-bordered table-hover" id="dataTables-list">
    <thead>
        <tr>
            <th data-name="username">Username</th>
            <th data-name="email">Email</th>
            <th data-name="auth_group">Group</th>
            <th data-name="action">Action</th>
            <th data-name="desc">Desc</th>
            <th data-name="created" data-searchable="false">Create Date</th>
        </tr>
    </thead>
</table>
<br/><br/>
<script type="text/javascript">
    list_dataTables('#dataTables-list','<?= $url_data ?>');
</script>
