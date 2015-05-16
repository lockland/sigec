function setRowClick(){
    $('#list table tbody tr').click(function(event){
        var background = $(this).css('background-color');
        $(this).parent().children().css('background-color', background);
        $(this).css('background-color', '#ccc');
        var tds = $(this).children('td');
        $('input[name=id]').attr('value',tds[0].innerHTML);
    });
}

function update(){
    var id = $('input[name=id]').val();
    if (id == 0) {
        alert("Clique em um dos itens da lista");
        return false;
    }

    window.location = $('#url-base').val() + "/index.php/" + $('#controller').val() + "/update/id/" + id;
}

$(document).ready(function() {
    setRowClick();
});
