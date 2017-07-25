
<html >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title> Cadastro </title>

<script>
function gonow() {
                document.getElementById('chat').contentWindow.scrollTo(10,0);}
</script>

</head>

<body onLoad="gonow()">

<div align="center"><form action="inserindo.php" method="post" name="chat" id="chat">
<table width="450" border="0" cellpadding="0" cellspacing="3">

    <tr>
                <td valign="top"><div align="right">Mensagem:</div></td>
        <td><textarea name="mensagem" cols="60" rows="5" id="mensagem"></textarea></td>
    </tr>
    <tr>
    <td height="29" colspan="2" valign="top"><div align="center">
                <input type="submit" name="Submit" value="enviar comentario" />
        </div>
        </td>
        </tr>
        </table>
 </form>
 <iframe  id="chat" src="exibir.php" width="800" height="200" name="chat" scrolling="auto"></iframe>
 </div>
 <div style="clear:both"></div>
</body>
</html>