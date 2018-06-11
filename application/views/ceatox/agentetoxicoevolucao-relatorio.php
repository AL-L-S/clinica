 <div>
<h3>Prefeitura Municipal de Fortaleza </h3>
<h3>Instituto Dr. Jos&eacute; Frota </h3>
<h5>Período: 01/01/2009 a 31/12/2009 </h5>
<h5>Casos Registrados de Intoxicação Humana por AGENTE TÓXICO x EVOLUÇÃO </h5>




<table>

        <thead>
<?php $listaCirc = $this->ceatoxrelatorio_m->listarEvolucao();?>
        <tr>
       <th>Agente T&oacute;xico</th>
       <?php foreach ($listaCirc as $item){?>

                <th width="100px;">
                    <?php echo $item->descricao_evolucao;?>
                </th>

      <?php } ?>
        <th>TOTAL</th>
        </tr>
        </thead>
        <tbody>
<?php

     $lista = $this->ceatoxrelatorio_m->listarAgenteToxico();
     $lista2 = $this->ceatoxrelatorio_m->listarEvolucao();
     $iant = 0;?>

   <?php foreach ($lista as $item) { ?>
                <tr>
        <td width="300px;"><?php echo $item->descricao_agente_toxico; ?></td>
        <?php foreach ($lista2 as $item2) {

           $i = $item->codigo_agente_toxico;
           $j = $item2->codigo_evolucao;
           $i = str_pad($i, 2,"0",STR_PAD_LEFT);
           //$j = str_pad($j, 2,"0",STR_PAD_LEFT);

           ?>

               <td width="100px;"><?php echo $this->ceatoxrelatorio_m->listaTotalAgenteToxicoEvolucao($i,$j);?></td>


           <?php
          }?>
                  <td><?php $totalparcial = $this->ceatoxrelatorio_m->listaParcialAgenteToxico($i);
                  echo $totalparcial;
                  ?></td>
              </tr>
   <?php }
   ?>

        </tbody>
</table>

</div>
