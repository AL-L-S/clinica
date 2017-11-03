<?
$dataFuturo = date("Y-m-d");
$dataAtual = @$obj->_nascimento;
$date_time = new DateTime($dataAtual);
$diff = $date_time->diff(new DateTime($dataFuturo));
$teste = $diff->format('%Ya %mm %dd');
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Odontograma</title>
  <style>
  body { background-color: rgba(0,0,0,.1);}
  .dadosTitulo{ font-weight: bold; font-size: 13pt; }
  #dadosPaciente{ font-size: 12pt; }
  /*#dadosPaciente table td { margin: 5pt; }*/
  </style>
</head>
<body>
  <form id="dadosPaciente" action="#">
    <fieldset>
      <legend>Dados Paciente</legend>
      <table>
        <tr>
          <td width="400px;"><span class="dadosTitulo">Paciente:</span> <?= @$obj->_nome ?></td>
          <td width="400px;"><span class="dadosTitulo">Exame:</span> <?= @$obj->_procedimento ?></td>
          <td width="400px;"><span class="dadosTitulo">Solicitante:</span> <?= @$obj->_solicitante ?></td>
        </tr>
        <tr>
          <td><span class="dadosTitulo">Idade:</span> <?= $teste ?></td>
          <td><span class="dadosTitulo">Nascimento:</span> <?= substr(@$obj->_nascimento, 8, 2) . "/" . substr(@$obj->_nascimento, 5, 2) . "/" . substr(@$obj->_nascimento, 0, 4); ?></td>
          <td><span class="dadosTitulo">Sala:</span> <?= @$obj->_sala ?></td>
        </tr>
        <tr>
          <td><span class="dadosTitulo">Sexo:</span> <?= (@$obj->_sexo == "F")? "Feminino" : "Masculino" ?></td>
          <td><span class="dadosTitulo">Convenio:</span> <?= @$obj->_convenio; ?></td>
          <td><span class="dadosTitulo">Telefone:</span> <?= @$obj->_telefone ?></td>
        </tr>
      </table>
    </fieldset>
  </form>
  <br />
  <div id="odontograma">

  </div>

</body>
</html>
<!-- <script type="text/javascript" src="<?= base_url() ?>js/knockout-2.0.0.js"></script> -->
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.svg.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.svggraph.min.js"></script>
<!-- <script type="text/javascript" src="<?= base_url() ?>js/odontograma.js"></script> -->
<script>
    $('#odontograma').svg({
        settings:{ width: '620px', height: '250px' }
    });

    function desenhndoDentes(){

    }

    function renderizarOdontograma(){

    }

    function DenteModel(id, x, y) { // Objeto Dente
      var self = this;

      self.id = id;
      self.x = x;
      self.y = y;
    };

    function visaoOdontograma(){
      var dentes = [];
      // Dentes Esquerdos
      for(var i = 0; i < 8; i++){
        dentes.push(new DenteModel(18 - i, i * 25, 0));
      }
      for(var i = 3; i < 8; i++){
        dentes.push(new DenteModel(55 - i, i * 25, 1 * 40));
      }
      for(var i = 3; i < 8; i++){
        dentes.push(new DenteModel(85 - i, i * 25, 2 * 40));
      }
      for(var i = 0; i < 8; i++){
        dentes.push(new DenteModel(48 - i, i * 25, 3 * 40));
      }
      // Dentes Direitos
      for(var i = 0; i < 8; i++){
        dentes.push(new DenteModel(21 + i, i * 25 + 210, 0));
      }
      for(var i = 0; i < 5; i++){
        dentes.push(new DenteModel(61 + i, i * 25 + 210, 1 * 40));
      }
      for(var i = 0; i < 5; i++){
        dentes.push(new DenteModel(71 + i, i * 25 + 210, 2 * 40));
      }
      for(var i = 0; i < 8; i++){
        dentes.push(new DenteModel(31 + i, i * 25 + 210, 3 * 40));
      }
    }

    odontograma = new visaoOdontograma();
    console.log(odontograma);


</script>
