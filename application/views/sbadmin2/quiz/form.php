<div class="row">
    <div class="col-lg-12">
        <div class="form-message">
            <?php 
            if (isset($form_message)) {
                echo $form_message;
            }
            ?>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <?=$page_title?> Form
            </div>
            <div class="panel-body">
                <?php echo form_open($form_action,'role="form" enctype="multipart/form-data"'); ?>
                    <!-- /#quiztabs -->
                    <div role="tabpanel" id="tabster">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#quiz" aria-controls="quiz" role="tab" data-toggle="tab">Quiz Info</a></li>
                            <li role="presentation"><a href="#question" aria-controls="question" role="tab" data-toggle="tab">Question</a></li>
                        </ul><!-- Nav tabs -->
                        <!-- /.tab content -->
                        <div class="tab-content">
                            <!-- /#quiz -->
                            <div role="tabpanel" class="tab-pane fade in active" id="quiz">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="quiz_title">Quiz Title</label>
                                            <input type="text" class="form-control" name="quiz_title" id="quiz_title" value="<?=(isset($post['quiz_title'])) ? $post['quiz_title'] : ''?>"/>
                                        </div>
                                        <div class="form-group">
                                            <label for="quiz_content">Quiz Content</label>
                                            <textarea class="form-control ckeditor" name="quiz_content" id="quiz_content" rows="5"><?=(isset($post['quiz_title'])) ? $post['quiz_content'] : ''?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="start_date">Start Date</label>
                                            <input type="text" class="form-control" name="start_date" id="start_date" value="<?=(isset($post['start_date'])) ? $post['start_date'] : date('Y-m-d')?>"/>
                                        </div>
                                        <div class="form-group">
                                            <label for="end_date">End Date</label>
                                            <input type="text" class="form-control" name="end_date" id="end_date" value="<?=(isset($post['end_date'])) ? $post['end_date'] : date('Y-m-d')?>"/>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-lg-offset-2">
                                        <div class="form-group">
                                            <label for="quiz_status">Status</label>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" value="1" name="quiz_status" id="quiz_status" <?=(isset($post['quiz_status']) && !empty($post['quiz_status'])) ? 'checked="checked"' : ''?>/>Active
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="image">Image</label>
                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail fileinput-upload" style="width: 200px; height: 150px;">
                                                    <?php if (isset($post['quiz_image']) && $post['quiz_image'] != '' && file_exists(UPLOAD_DIR.'quiz/'.$post['quiz_image'])): ?>
                                                        <img src="<?=RELATIVE_UPLOAD_DIR.'quiz/'.$post['quiz_image']?>" id="post-image" />
                                                        <span class="btn btn-danger btn-delete-photo" id="delete-picture" data-id="<?=$post['id_quiz']?>">x</span>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
                                                <div>
                                                    <span class="btn btn-default btn-file">
                                                        <span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span>
                                                        <input type="file" name="image">
                                                    </span>
                                                    <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- /#quiz -->
                            <!-- /#answer -->
                            <div role="tabpanel" class="tab-pane fade" id="question">
                                <div class="row group-form-field">
                                    <?php foreach ($post['question'] as $row => $question): ?>
                                    <div class="row-question">
                                        <div class="col-lg-8">
                                            <div class="form-group">
                                                <label for="question_<?=$row?>">Question</label>
                                                <textarea class="form-control" name="question[<?=$row?>][question]" id="question_<?=$row?>"><?=(isset($question['question'])) ? $question['question'] : ''?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label for="question_type_<?=$row?>">Type</label>
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" name="question[<?=$row?>][question_type]" id="question_type_<?=$row?>_1" value="1" >Input Text
                                                    </label>
                                                </div>
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" name="question[<?=$row?>][question_type]" id="question_type_<?=$row?>_2" value="2" >Textarea
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label for="question_position_<?=$row?>">Position</label>
                                                <input type="text" class="form-control" name="question[<?=$row?>][position]" id="question_position_<?=$row?>" value="<?=(isset($question['position'])) ? $question['position'] : ''?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                                <div class="row group-form-button">
                                    <div class="col-lg-2 col-lg-offset-10 text-right">
                                        <button type="button" class="btn btn-success" onclick="addQuestion();">+</button>
                                    </div>
                                </div>
                            </div><!-- /#answer -->
                        </div><!-- /.tab content -->
                    </div><!-- /#quiztabs -->
                    <div class="row">
                        <div class="col-lg-4 col-lg-offset-8">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a class="btn btn-danger" href="<?=$cancel_url?>">Cancel</a>
                        </div>
                    </div>
                    <!-- /.row (nested) -->
                <?php echo form_close(); ?>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>

<script type="text/javascript">
    $(function() {
        <?php if (isset($post['id_site'])): ?>
        $("#delete-picture").click(function() {
            var self = $(this);
            var id = self.attr('data-id');
            var post_delete = [{name:"id",value:id}];
            post_delete.push({name:token_name,value:token_key});
            $.ajax({
                url:'<?=$delete_picture_url?>',
                type:'post',
                data:post_delete,
                dataType:'json',
                beforeSend: function() {
                    self.attr('disabled',true);
                }
            }).always(function() {
                self.removeAttr('disabled');
            }).done(function(data) {
                if (data['error'])  {
                    $(".flash-message").html(data['error']);
                }
                if (data['success']) {
                    $(".flash-message").html(data['success']);
                    $("#post-image").remove();
                    self.remove();
                }
            });
        });
        <?php endif; ?>
    });
    var html;
    function addQuestion() {
        var row = $(".row-question").length;
        var not_show = '';
        if (row > 0) {
            not_show = 'style="display:none;"';
        }
        html = '\
            <div class="group-form row-form">\
                <div class="form-group col-md-3">\
                    <label for="name_'+row+'" '+not_show+'>Nama</label>\
                    <input class="form-control" required="required" id="name_'+row+'" name="suggest['+row+'][name]" type="text" placeholder="Name"/>\
                </div>\
                <div class="form-group col-md-3">\
                    <label for="email_'+row+'" '+not_show+'>Email</label>\
                    <input class="form-control" required="required" id="email_'+row+'" name="suggest['+row+'][email]" type="email" placeholder="Email"/>\
                </div>\
                <div class="form-group col-md-2">\
                    <label for="phone_'+row+'" '+not_show+'>Phone</label>\
                    <input class="form-control" required="required" id="phone_'+row+'" name="suggest['+row+'][phone]" type="text" placeholder="contoh: 021-7777777"/>\
                </div>\
                <div class="form-group col-md-2">\
                    <label for="phone2_'+row+'" '+not_show+'>Phone 2</label>\
                    <input class="form-control" required="required" id="phone2_'+row+'" name="suggest['+row+'][phone2]" type="text" placeholder="contoh: 021-7777777"/>\
                </div>\
            </div>';
        $(".group-form-field").append(html);
        //row++;
    }
</script>