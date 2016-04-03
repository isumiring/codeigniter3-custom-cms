<div class="row top-cursor">
    <div class="col-md-4 col-md-offset-8 text-right">
        <a href="<?php echo $add_url; ?>" class="btn btn-success">Add</a>
        <button type="button" class="btn btn-danger delete-record" id="delete-record">Delete</button>
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
        <a href="<?php echo $add_url; ?>" class="btn btn-success">Add</a>
        <button type="button" class="btn btn-danger delete-record" id="delete-record">Delete</button>
    </div>
</div>
<br/><br/>
<script type="text/javascript">
    list_dataTables('#dataTables-list','<?php echo $url_data; ?>');
    $('#dataTables-list').unbind("click");
    $("#dataTables-list").on('click',' tbody tr td .set-default', function(e) {
        e.preventDefault();
        var self = $(this),
            self_html = $(this).html();
        if (typeof self.data('id') !== 'undefined') {
            var data = [
                {'name': 'localization_id', 'value': self.data('id')}
            ];
            submit_ajax('<?php echo $set_default_url; ?>', data, self)
                .done(function(response) {
                    if(response['error']) {
                        self.html(self_html);
                    }
                    if (response['status'] == 'success') {
                        self.parent().html(response['response_text']);
                        if (response['redirect']) {
                            window.location = response['redirect'];
                        }
                    }
                    self.html(self_html).removeAttr('disabled');
                });
        }
    });
</script>
