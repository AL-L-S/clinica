 <div>
<h3>Prefeitura Municipal de Fortaleza </h3>
<h3>Instituto Dr. Jos&eacute; Frota </h3>
<h5>Período: 01/01/2009 a 31/12/2009 </h5>
<h5>Casos Registrados de Intoxicação Humana por AGENTE TÓXICO x ZONA DE OCORRÊNCIA </h5>




<table>

        <thead>
        <tr>
                <th width="100px;">Agente T&oacute;xico</th>
                <th width="100px;">01-04</th>
                <th width="100px;">05-09</th>
                <th width="100px;">10-14</th>
                <th width="100px;">15-19</th>
                <th width="100px;">20-29</th>
                <th width="100px;">30-39</th>
                <th width="100px;">40-49</th>
                <th width="100px;">50-59</th>
                <th width="100px;">60-69</th>
                <th width="100px;">70-79</th>
                <th width="100px;">ACIMA 80</th>
                <th width="100px;">TOTAL</th>
        </tr>
        </thead>
        <tbody>

<?php $lista = $this->ceatoxrelatorio_m->listarAgenteToxico(); ?>

   <?php foreach ($lista as $item) { ?>
                <tr>
            <td width="300px;"><?php echo $item->descricao_agente_toxico; ?></td>
            <?php
           $id1=0;
           $id2=0;
           $id3=0;
           $id4=0;
           $id5=0;
           $id6=0;
           $id7=0;
           $id8=0;
           $id9=0;
           $id10=0;
           $id11=0;
           $i = $item->codigo_agente_toxico;
           $i = str_pad($i, 2,"0",STR_PAD_LEFT);
           $lista2 = $this->ceatoxrelatorio_m->listaParcialNotificacao($i);
           foreach ($lista2 as $item2) {
               $idade = substr($item2->idade, 0, 2);
               $idade = $idade*1;
               if($idade>0 && $idade<5){
                   $id1++;
               }else{
                   if($idade>4 && $idade<10){
                      $id2++;
                   }else{
                        if($idade>9 && $idade<15){
                            $id3++;
                        }else{
                            if($idade>14 && $idade<20){
                                $id4++;

                            }else{
                                 if($idade>19 && $idade<30){
                                     $id5++;

                                 }else{
                                     if($idade>29 && $idade<40){
                                         $id6++;
                                     }else{
                                        if($idade>39 && $idade<50){
                                            $id7++;
                                        }else{
                                            if($idade>49 && $idade<60){
                                                $id8++;
                                            }else{
                                                if($idade>59 && $idade<70){
                                                    $id9++;
                                                }else{
                                                    if($idade>69 && $idade<80){
                                                        $id10++;
                                                    }else{
                                                        if($idade>80){
                                                            $id11++;
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                     }
                                 }
                                }
                            }
                        }
                   }
               }
               ?>
            <td><?= $id1;?></td>
            <td><?= $id2;?></td>
            <td><?= $id3;?></td>
            <td><?= $id4;?></td>
            <td><?= $id5;?></td>
            <td><?= $id6;?></td>
            <td><?= $id7;?></td>
            <td><?= $id8;?></td>
            <td><?= $id9;?></td>
            <td><?= $id10;?></td>
            <td><?= $id11;?></td>
          <td><?php $totalparcial = $this->ceatoxrelatorio_m->listaParcialAgenteToxico($i);
          echo $totalparcial;
          ?></td>
                </tr>
          <?php }
           ?>



        </tbody>
</table>

</div>
