window.onload = startScript;
function startScript(){


    $('#addAnnouncement').click(function(){
        var userNameValidation = document.getElementById('userID').value;
        if (userNameValidation === '' || userNameValidation === null){
            userNameMessage = document.getElementById('userID');
            userNameMessage.style.background = 'red';
            userNameMessage.innerHTML = 'Please enter your User Id';
            userNameMessage.style.color = 'white';
            userNameMessage.focus();
            return false;

        }
        var subjectLineValidation = document.getElementById('subjectLine').value;
        if (subjectLineValidation === '' || subjectLineValidation === null){
            subjectLineMessage = document.getElementById('subjectLine');
            subjectLineMessage.style.background = 'red';
            subjectLineMessage.innerHTML = 'Please enter a title for your announcement';
            subjectLineMessage.style.color = 'white';
            subjectLineMessage.focus();
            return false;
        }
        var announcementValidation = document.getElementById('announcement').value;
        if (announcementValidation === '' || announcementValidation === null){
            announcementMessage = document.getElementById('announcement')
            announcementMessage.style.background = 'red';
            announcementMessage.innerHTML = 'Please type an announcement';
            announcementMessage.style.color = 'white';
            announcementMessage.focus();
            return false;
        }

        //return false;

    });


}


