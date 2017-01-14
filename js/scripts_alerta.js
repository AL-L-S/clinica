$("#document").ready(function(){
    

    $(".div-mensagem").dialog({
        resizable: false,
        height:170,
        modal: true,
        buttons: {
            "OK": function() {
                $( this ).dialog( "close" );
            }
        }
    });

});