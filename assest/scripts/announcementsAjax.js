$(document).ready(function(){
    $("#addAnnouncement").click(function(){
        var userID = $("#userID").val();
        var subjectLine = $("#subjectLine").val();
        var announcement = $("#announcement").val();
        $.ajax({

            url: "gatheringsPage.php",
            type: "POST",
            async: false,
            data: {
                "done" : 1,
                "userid" : userIDax,
                "subjectline_text" : subjectLineax,
                "announcement_text" : announcementax
            },
            success:  function(data){


            }
        })

    });


});
