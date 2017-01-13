$("#document").ready(function(){
    $(".espec").hide("fast")

    $('.bestupper').bestupper({
        ln: 'tr'
    });

    $("select").change(function(){
        var classeInput = this.id;
        valorSelecionado = "#" + this.id + " option:selected";
        valorParaTeste = ( $(valorSelecionado).text());
        
        spanClass = "." + classeInput + "_desc";
        selectId = "#"+ classeInput + "_desc";
        spanClass2 = "." + classeInput + "_spanselect1";
        selectId2 = "#"+ classeInput + "_select1";
        selectId3 = "#"+ classeInput + "_select2";
        selectId4 = "#" + classeInput + "_select4";
        selectId5 = "#"+ classeInput + "_select5";
        selectId6 = "#"+ classeInput + "_select6";

        if(valorParaTeste == "Outro" || valorParaTeste == "Outro Prof. Saúde" || valorParaTeste == "Outro serviços. públicos"){
            $(spanClass).show();
            $(selectId).show();
            $(selectId).focus();           
        }
        else{
            $(spanClass).hide();
            $(selectId).hide();
        }
        
        if(situacao == "FINALIZADO"){
            $(spanClass).show();
            $(selectId).show();
            $(selectId).focus();
        }
        else{
            $(spanClass).hide();
            $(selectId).hide();
        }
        if((valorParaTeste == "Sim") && (this.id == "toxicologica")){
            $(spanClass).show();
            $(selectId).show();
            $(selectId).focus();
        }
        else{
            $(spanClass).hide();
            $(selectId).hide();
        }
        if((valorParaTeste == "Adiamento")){

            $(spanClass).show();
            $(selectId).show();
            $(selectId3).show();
            $(selectId).focus();
        }
        else{
            $(selectId3).hide();
        }
        if(valorParaTeste == "Transferencia"){
            $(spanClass2).show();
            $(selectId2).show();
            $(selectId2).focus();
        }
        else{
            $(spanClass2).hide();
            $(selectId2).hide();
        }
        if(valorParaTeste == "Adulto"){
            $(selectId4).show();
            $(selectId4).focus();
        }
        else{
            $(selectId4).hide();
        }

        if((valorParaTeste == "Crianca")){

            $(selectId5).show();
            $(selectId5).focus();
        }
        else{
            $(selectId5).hide();
        }
        if(valorParaTeste == "Recem nascidos"){
            $(selectId6).show();
            $(selectId6).focus();
        }
        else{
            $(selectId6).hide();
        }

    });

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