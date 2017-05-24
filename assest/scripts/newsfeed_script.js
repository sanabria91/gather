$(document).ready(function(){

    //on add click  grab all the vals from the form inputs that were subitted form newsfeed index
    $("#Add").click(function(){
        //alert($("#postimage").val());
        var newsfeed_post=$("#newsfeed_post").val();
        var postimage=$("#postimage").val();
        var user_id=$("#user_id").val();
        var user_name=$("#user_name").val();
        var dateposted=$("#dateposted").val();

        //make an jax call to go to the ajaxcode.php file -> where data submission will take place
        $.ajax({
            url:'../AjaxCode/ajaxcode.php',
            data:{ //Decalre all of the data I want to take with when the code goes to the url
                task:'SavePost', //task acts liek placeholder for what job to do - to be used in the switch in ajaxcode.php
                post:newsfeed_post,
                img:postimage,
                userid:user_id,
                username:user_name,
                postdate:dateposted

            },
            type:'POST', //to send using the post method
            cache:false, //cache is always false - ask nithya about the in depth reason as to why
            success:function(response) {

                loadPosts(); //on success - callin the loadposts function which is below and loads all posts using ajax



            }
        });
    });//add button click


    function loadPosts() {
        $.ajax({
            url:'../AjaxCode/ajaxcode.php',
            data:{
                task:'loadPost',
            },
            type:'POST',
            cache:false,
            success:function (data) {
                $("#postforeach").empty().append(data);
            }
        });//inner ajax
    }

    $("#postforeach").on('click',"#btnLike",function () {

        var id=$(this).data('id');
        //alert(id);
        $.ajax({
            url:'../AjaxCode/ajaxcode.php',
            data:{
                task:'incrementLike',
                postid:id,
            },
            type:'POST',
            cache:false,
            success:function (data) {
                loadPosts();
            }
        });


    });

    //btnDelete
    $("#postforeach").on('click',"#btnDelete",function () {

        var id=$(this).data('id');
        //alert(id);
        $.ajax({
            url:'../AjaxCode/ajaxcode.php',
            data:{
                task:'deletePost',
                postid:id,
            },
            type:'POST',
            cache:false,
            success:function (data) {
                loadPosts();
            }
        });


    });

});//end of onload function
