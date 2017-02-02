<div class="row">
    <div class="col-xs-12">
        <div class="box box-dttables box-info">
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
		</div>
		<!--/.box-dttables-->
	</div>
</div>
<!--/.row-->
<script type="text/javascript">
    list_dataTables('#dataTables-list', '<?php echo $url_data; ?>');
</script>
