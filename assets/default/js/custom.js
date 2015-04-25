
/**
 * this library is required jquery and other library
 * 
 */
function list_dataTables(element,url) {
    $(document).ready(function () {
        var selected = [];
        var sort_field = ($(element+' thead th.default_sort').index(element+' thead th') > 0 ) ? $(element+' thead th.default_sort').index(element+' thead th') : 1;
        var sort_by = ($(element+' thead th.default_sort').index(element+' thead th') > 0 ) ? "desc" : "asc";
        var colom = [];
        var i=0;
        $(element+' thead th').each(function() {
            var edit = $(this).data('edit');
            var view = $(this).data('view');
            colom[i] = {
                'data':(typeof $(this).data('name') === 'undefined') ? null : $(this).data('name'),
                'name':(typeof $(this).data('name') === 'undefined') ? null : $(this).data('name'),
                'searchable':(typeof $(this).data('searchable') === 'undefined') ? true : $(this).data('searchable'),
                'sortable':(typeof $(this).data('searchable') === 'undefined') ? true : $(this).data('searchable'),
                'className':(typeof $(this).data('classname') === 'undefined') ? null : $(this).data('classname')
            };
            i++;
        });
        //console.log(colom);
        var DTTable = $(element).DataTable({
            "processing": true,
            "serverSide": true,
            /*"ajax": $.fn.dataTable.pipeline({
                url: url,
                pages: perpage // number of pages to cache
            })*/
            "ajax": {
                "url": url,
                "type": "POST"
            },
            "rowCallback": function( row, data ) {
                if ( $.inArray(data.DT_RowId, selected) !== - 1) {
                    $(row).addClass('selected');
                }
            },
            "columns":colom,
            "order":[[sort_field,sort_by]]
        });
        /*
        // edit record
        //$(element+' tbody').on('click', 'td.details-control', function () {
        $(element+' tbody').on('click', 'td.details-control span', function () {
            var selfspan = $(this);
            var selfurl = selfspan.data('url');
            var tr = this.closest('tr');
            var id = tr.id;
            window.location.href = current_ctrl+selfurl+'/'+id;
        });
        */
        // selected row
        $(element+' tbody').on('click', 'tr', function () {
            var id = this.id;
            var index = $.inArray(id, selected);

            if ( index === -1 ) {
                selected.push( id );
            } else {
                selected.splice( index, 1 );
            }
            $("#delete-record-field").val(selected);

            $(this).toggleClass('selected');
        });
        // delete record
        $(document).on('click', '#delete-record', function () {
            if (selected.valueOf() != '') {
                var conf = confirm('Are You sure want to delete this record(s)?');
                if (conf) {
                    $.ajax({
                        url:current_ctrl+'delete',
                        type:'post',
                        data:'ids='+selected,
                        dataType:'json'
                    }).
                    done(function(data) {
                        if (data['success']) {
                            $(".flash-message").html(data['success']);
                            $(element+' tbody tr.selected').remove();
                            DTTable.draw();
                        }
                        if (data['error']) {
                            $(".flash-message").html(data['error']);
                        }
                    })
                    ;
                }
            }
        });
    });
}
