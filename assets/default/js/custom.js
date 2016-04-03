/**
 * custom script
 * @author ivan lubis
 * @version 2.0
 * @description this library is required jquery and other library
 */

function convert_to_uri(val)
{
    return val
        .toLowerCase()
        .replace(/ /g,'-')
        .replace(/[^\w-]+/g,'')
        ;
}

/**
 * ajax post
 * @param string url
 * @param array data 
 * @return object/var
 */
function ajax_post(url,data) {
    data.push({name:token_name,value:token_key});
    var callback = $.ajax({
        url:url,
        type:'post',
        dataType:'json',
        data:data,
        cache:false
    });
    return callback;
}

/**
 * submit via ajax by button
 * @param string url
 * @param array data
 * @param object this_var
 * @returns object/var
 */
function submit_ajax(url,data,this_var) {
    data.push({name:token_name,value:token_key});
    var callback = $.ajax({
        url:url,
        type:'post',
        dataType:'json',
        data:data,
        cache:false,
        beforeSend:function() {
            if (this_var || typeof this_var !== 'undefined') {
                this_var.html('Loading...');
                this_var.attr('disabled',true);
            }
        }
    });
    return callback;
}
