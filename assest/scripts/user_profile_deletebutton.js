
window.onload = startScript;
function startScript(){

    $('#hidethedeletion').hide();

    $('#deleteNotifier').click(function(){
        $('#hidethedeletion').show();
    });
    $('#deletenope').click(function(){
        $('#hidethedeletion').hide();
    });
}
