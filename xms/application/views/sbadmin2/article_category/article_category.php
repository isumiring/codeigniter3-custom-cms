<div class="row top-cursor">
    <div class="col-md-4 col-md-offset-8 text-right">
        <a href="<?=$add_url?>" class="btn btn-success">Add</a>
        <button type="button" class="btn btn-danger delete-record" id="delete-record">Delete</button>
    </div>
</div>
<table class="table table-striped table-bordered table-hover" id="dataTables-list">
    <thead>
        <tr>
            <th width="20" data-searchable="false" data-orderable="false" data-name="actions" data-classname="text-center"></th>
            <th data-name="title">Title</th>
        </tr>
    </thead>
</table>

<br/><br/>
<input type="hidden" id="delete-record-field"/>
<div class="row">
    <div class="col-md-4 col-md-offset-8 text-right">
        <a href="<?=$add_url?>" class="btn btn-success">Add</a>
        <button type="button" class="btn btn-danger" id="delete-record">Delete</button>
    </div>
</div>
<br/><br/>
<script type="text/javascript">
    list_dataTables('#dataTables-list','<?= $url_data ?>');
</script>
