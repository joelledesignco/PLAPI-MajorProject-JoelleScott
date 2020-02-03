$(document).ready(function(){

    $('.chosen-select').chosen();

    $('.delete-btn').click(function(){
        if( !confirm('Are you sure you want to delete this?') ){
            return false;
        }
    });

    $('#project-feed').on('click', '.love-btn', function(){

        // Components to be updated
        var $love_btn = $(this);
        var $love_icon = $love_btn.find('.love-icon');
        var $love_btn_text = $love_btn.find('.love-btn-text');
        var $loves_count = $love_btn.closest('.project-post').find('.loves-count');

        // Values
        var project_id = $love_btn.closest('.project-post').attr('data-projectID');

        $.post('/loves/add.php', {"project_id":project_id}, function(love_data){
            console.log(love_data);

            if( love_data.error === false ){ // loving worked!
                if( love_data.loved == 'loved' ){
                    $love_icon.removeClass('far').addClass('fas');
                    $love_btn_text.text('Loved!');
                    $loves_count.text(love_data.love_count);
                }else if( love_data.loved == 'unloved' ){
                    $love_icon.removeClass('fas').addClass('far');
                    $love_btn_text.text('Love it');
                    $loves_count.text(love_data.love_count);
                }
            }
        });
    });

    $('#project-feed').on('submit', '.comment-form', function(e){
        e.preventDefault();

        // Components
        var $commentForm = $(this);
        var $commentBox = $commentForm.find('.commentForm-commentbox');
        var $commentCount = $commentForm.closest('.project-post').find('.comment-count');
        var $comment_loop = $commentForm.closest('.project-post').find('.comment-loop');

        // Values
        var project_id = $commentForm.closest('.project-post').attr('data-projectID');
        var comment = $commentBox.val();

        if( $.trim(comment).length > 0 ){ // They typed something

            $.post('/comments/add.php', {"project_id":project_id,"comment":comment}, function(comment_data){
                console.log(comment_data);

                if( comment_data.error === false ){
                    $commentCount.text(comment_data.comment_count);

                    var commentLoopHtml = '';
                    $.each(comment_data.comments, function(key, comment){

                        commentLoopHtml += '<div class="user-comment">';
                        if( comment.user_owns == 'true' ){
                            commentLoopHtml += '<i class="fas fa-times-circle delete-comment-btn" data-commentID="'+comment.id+'"></i>';
                        }

                            commentLoopHtml += '<p><span class="font-weight-bold comment-username">'+comment.username+'</span> '+comment.comment+'</p>';
                            commentLoopHtml += '</div>';
                    }); // END EACH LOOP

                    $comment_loop.html(commentLoopHtml);
                    $commentBox.val('');
                }
            });
        }
    });

    $('#project-feed').on('click', '.delete-comment-btn', function(){

        // Components
        $commentCount = $(this).closest('.project-post').find('.comment-count');

        // Values
        var comment_id = $(this).attr('data-commentID');
        var project_id = $(this).closest('.project-post').attr('data-projectID');

        $(this).closest('.user-comment').remove();

        $.post('/comments/delete.php', {'comment_id':comment_id, 'project_id':project_id}, function(comment_data){

            console.log(comment_data);

            $commentCount.text(comment_data.comment_count);

        });
    });

}); // END DOCUMENT READY

function previewFile() {

    var preview = document.getElementById('img-preview');
    var file = document.getElementById('file-with-preview').files[0];

    var reader = new FileReader();

    reader.onloadend = function(){
        preview.src = reader.result;
    }

    if(file) {
        reader.readAsDataURL(file);
    }else{
        preview.src = "";
    }
}
