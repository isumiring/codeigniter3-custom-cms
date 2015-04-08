<table class="table table-striped table-bordered table-hover" id="dataTables-list">
    <thead>
        <tr>
            <th>Username</th>
            <th>Name</th>
            <th>Email</th>
            <th>Group</th>
            <th>Create Date</th>
        </tr>
    </thead>
</table>

<script type="text/javascript">
    list_data_table('#dataTables-list','<?= $url_data ?>',<?= $record_perpage ?>);
</script>
