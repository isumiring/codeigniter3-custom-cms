<table class="table table-striped table-bordered table-hover" id="dataTables-list">
    <thead>
        <tr>
            <th data-name="pelanggan_id">Customer ID</th>
            <th data-name="name">Name</th>
            <th data-name="email">Email</th>
            <th data-name="phone">Phone</th>
            <th data-name="phone2">Phone (2)</th>
            <th data-name="create_date" data-searchable="false">Create Date</th>
        </tr>
    </thead>
</table>
<br/><br/>
<script type="text/javascript">
    list_dataTables('#dataTables-list','<?= $url_data ?>');
</script>
