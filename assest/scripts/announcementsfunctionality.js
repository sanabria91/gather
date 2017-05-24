/*JAVASCRIPT PAGE FOR ANNOUNCEMENT FEATURE*/

//TASK 1 - CREATING A HIDDEN FIELD FOR ANNOUNCEMENTS SO THAT ON CLICK, ANNOUNCEMENTS CAN BE DISPLAYED

//Step 1 - Ready Function
$(document).ready(function(){

    //alert('supppp');

//Step 2 - AutoHide Elements

//2.1 - Hidden Announcement Postings and hidden "Close Announcements" Button
    $('.AnnouncementResults').hide();
    $('.viewAnnouncementsButtonhidden').hide();



//Step 3 - Onclick function to show announcements
    $('.viewAnnouncementsButton').click(
        function() {
            $('.AnnouncementResults').slideToggle(1000);
            $('.viewAnnouncementsButton').hide();
            $('.viewAnnouncementsButtonhidden').show();
        })
    $('.viewAnnouncementsButtonhidden').click(
        function(){
            $('.AnnouncementResults').slideToggle(1000);
            $('.viewAnnouncementsButtonhidden').hide();
            $('.viewAnnouncementsButton').show();
        }
    );
});