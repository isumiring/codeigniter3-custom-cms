
/**
 * this library is required jquery and other library
 * 
 */
function list_dataTables(element,url) {
    $(document).ready(function () {
        var selected = [];
        var sort = [];
        if ($(element+' thead th.default_sort').index(element+' thead th') > 0) {
            sort.push([$(element+' thead th.default_sort').index(element+' thead th'),"desc"]);
        }
        var colom = [];
        var i=0;
        var objToken = {};
        objToken[token_name] = token_key
        $(element+' thead th').each(function() {
            var edit = $(this).data('edit');
            var view = $(this).data('view');
            colom[i] = {
                'data':(typeof $(this).data('name') === 'undefined') ? null : $(this).data('name'),
                'name':(typeof $(this).data('name') === 'undefined') ? null : $(this).data('name'),
                'searchable':(typeof $(this).data('searchable') === 'undefined') ? true : $(this).data('searchable'),
                'sortable':(typeof $(this).data('orderable') === 'undefined') ? true : $(this).data('orderable'),
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
                "type": "POST",
                "data": objToken
            },
            "rowCallback": function( row, data ) {
                if ( $.inArray(data.DT_RowId, selected) !== - 1) {
                    $(row).addClass('selected');
                }
            },
            "columns":colom,
            "order":sort
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
                console.log(objToken);
                var post_delete = [{name:"ids",value:selected}];
                post_delete.push({name:token_name,value:token_key});
                var conf = confirm('Are You sure want to delete this record(s)?');
                if (conf) {
                    $.ajax({
                        url:current_ctrl+'delete',
                        type:'post',
                        data:post_delete,
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
