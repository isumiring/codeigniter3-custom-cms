<div class="row top-cursor">
    <div class="col-md-4 col-md-offset-8 text-right">
        <a href="<?=$add_url?>" class="btn btn-success">Add</a>
    </div>
</div>
<table class="table table-striped table-bordered table-hover" id="dataTables-list">
    <thead>
        <tr>
            <th data-name="locale">Locale/Language</th>
            <th data-name="iso_1">ISO 1</th>
            <th data-name="iso_2">ISO 2</th>
            <th data-name="locale_path">Path</th>
            <th data-name="locale_status" data-searchable="false">Status</th>
        </tr>
    </thead>
</table>

<br/><br/>
<div class="row">
    <div class="col-md-4 col-md-offset-8 text-right">
        <a href="<?=$add_url?>" class="btn btn-success">Add</a>
    </div>
</div>
<br/><br/>
<script type="text/javascript">
    list_dataTables('#dataTables-list','<?= $url_data ?>');
</script>
