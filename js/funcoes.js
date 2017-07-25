/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
function retornaIdade()
{

var idade = 0;
var dataHoje = new Date();

var anoAtual = dataHoje.getTime()/(1000*60*60*24*360);
var mesAtual = dataHoje.getTime()/(1000*60*60*24*12);
var diaAtual = dataHoje.getTime()/(1000*60*60*24);

var idadeSuposto = document.form_paciente.nascimento.value;
if(idadeSuposto!=""){
var anoSuposto =new Date(idadeSuposto).getTime()/(1000*60*60*24*360);
var mesSuposto = new Date(idadeSuposto).getTime()/(1000*60*60*24*12);
var diaSuposto = new Date(idadeSuposto).getTime()/(1000*60*60*24);

idade = anoAtual - anoSuposto;
if (mesAtual < mesSuposto)
{idade = idade -1;
elseif (mesAtual == mesSuposto  && diaSuposto > $diaAtual)
 {idade = idade -1;}
if (idade == -1)
{idade = 0;}
}
    document.form_paciente.idade.value = Math.floor(idade);
}else{
    
    document.form_paciente.idade.value = 0;
}
}

function retornaIdade2()
{

var idade = 0;
var dataHoje = new Date();

var anoAtual = dataHoje.getTime()/(1000*60*60*24*360);
var mesAtual = dataHoje.getTime()/(1000*60*60*24*12);
var diaAtual = dataHoje.getTime()/(1000*60*60*24);

var idadeSuposto = document.form_exametemp.nascimento.value;
if(idadeSuposto!=""){
var anoSuposto =new Date(idadeSuposto).getTime()/(1000*60*60*24*360);
var mesSuposto = new Date(idadeSuposto).getTime()/(1000*60*60*24*12);
var diaSuposto = new Date(idadeSuposto).getTime()/(1000*60*60*24);

idade = anoAtual - anoSuposto;
if (mesAtual < mesSuposto)
{idade = idade -1;
elseif (mesAtual == mesSuposto  && diaSuposto > $diaAtual)
 {idade = idade -1;}
if (idade == -1)
{idade = 0;}
}
    document.form_exametemp.idade.value = Math.floor(idade);
}else{
    
    document.form_exametemp.idade.value = 0;
}
}
