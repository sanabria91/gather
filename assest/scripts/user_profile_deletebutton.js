
window.onload = startScript;
function startScript(){

//Default hidden values
    $('#editdelete').hide();
    $('#hidethedeletion').hide();
    $('#hiddenhider').hide();


    $('#hider').click(function() {
        $('#editdelete').slideToggle(1000);
        $('#hider').hide();
        $('#hiddenhider').show();

        $('#hiddenhider').click(function () {
            $('#editdelete').slideToggle(1000);
            $('#hiddenhider').hide();
            $('#hider').show();


            $('#deleteNotifier').click(function () {
               $('#hidethedeletion').show();
                //$('#hidethedeletion').show("slide", { direction: "right" }, 1000);
            });

            $('#deletenope').click(function () {
                $('#hidethedeletion').hide();
            });

        });
    });

}
// $('.viewAnnouncementsButton').click(
//     function() {
//         $('.AnnouncementResults').slideToggle(1000);
//         $('.viewAnnouncementsButton').hide();
//         $('.viewAnnouncementsButtonhidden').show();
//     })
// $('.viewAnnouncementsButtonhidden').click(
//     function(){
//         $('.AnnouncementResults').slideToggle(1000);
//         $('.viewAnnouncementsButtonhidden').hide();
//         $('.viewAnnouncementsButton').show();
//     }