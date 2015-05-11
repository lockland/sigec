function setRowClick(){
    $('#list table tbody tr').click(function(event){

        var background = $(this).css('background-color');
        var rowSelectedBackground = 'rgb(204, 204, 204)'; //#ccc

        if (background != rowSelectedBackground) {
            $(this).parent().children().css('background-color', background);
        }

        $(this).css('background-color', rowSelectedBackground);

        var fields = $(this).children('td');
        var ID = 0;
        $('input[name=id]').attr('value', fields[ID].innerHTML);
    });
}

function userUpdate(){
    var id = $('input[name=id]').val();
    if (id == 0) {
        alert("Clique em um dos itens da lista");
        return false;
    }

    window.location = $('#url-base').val() + "/index.php/User/update/id/" + id;
}

$(document).ready(function() {
    setRowClick();
});
