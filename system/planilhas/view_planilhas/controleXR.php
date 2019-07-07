<!-- View content -->
<!-- Título padrão para Cadastros -->
<div class="" style="margin-left: 20px" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Controle XR</h3>
      </div>

    </div>

    <div class="clearfix"></div>

    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <table id="datatable-responsive" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
         <!--  <tfoot>
            <tr>
              <th>Controle</th>
              <th>Descrição de Avarias</th>
              <th>Maquinas</th>
              <th>Media X</th>
              <th>Media LC X</th>
              <th>Media LCS</th>
              <th>Media LIC</th>
              <th>Amplitude</th>
              <th>LC R</th>
              <th>LCS</th>
              <th>LIC</th>
            </tr> 
          </tfoot> -->

          <tbody id="conteudo-table-cliente">

            <?php 
              // Essa chamada aponta para ServicePlanilhas a partir dessa página ('planilhas/view_planilhas/full.php')
              require_once('../ServicePlanilhas.class.php');
              $service = new ServicePlanilhas();

              if ($_POST['OC_CODIGO_ID'] != 0) {
                  
              } else {
                $problemas = $service->getProblemas();
                // $ocorrencias = $service->getDataOcorrencias();
                $maquinas = $service->getDataMaquinas();

                $thead = "<thead>";
                  $thead .= "<tr>";
                    $thead .= "<th>Controle</th>";
                    $thead .= "<th>Descrição de Avarias</th>";
                    // $thead .= <th>Maquinas</th>
                $theadMaquinas = "";
                
                $flag = false;
                $mediaX = 0;
                $mediaLCx = 0;
                $mediaLCs = 0;
                $amplitudeR = 0;
                $maxTempo = 0;
                $minTempo = 0;
                $amplitudeLCr = 0;

                $arrayMaxMin = [];
                $arrayLabelGrafico = [];
                $arrayMEDIAX = [];
                $arrayLCX = [];
                $arrayLCS = [];
                $arrayLIC = [];

                foreach ($problemas as $problema) {
                  $PR_CODIGO = "A".$service->ajustAtribute($problema['PR_CODIGO']);
                  $PR_DESCRICAO = $service->ajustAtribute($problema['PR_DESCRICAO']);

                  print '<tr>';
                      print '<td>'.$PR_CODIGO.'</td>'; // OKAY
                      print '<td>'.$PR_DESCRICAO.'</td>'; // OKAY
                      foreach ($maquinas as $maquina) {
                        if ($flag == false) {
                          $theadMaquinas .= "<th>".$maquina['MA_NOME']."</th>";
                        }
                        $tempo = $service->totalMinutosMaquina($maquina['MA_CODIGO'], $problema['PR_CODIGO']);
                        $mediaX += $tempo;
                        array_push($arrayMaxMin, $tempo);

                        print '<td>'.$tempo.'</td>'; // OKAY
                      }
                      // $max = $service->maxMinutosMaquina($problema['PR_CODIGO']);
                      // $min = $service->minMinutosMaquina($problema['PR_CODIGO']);
                      $max = max($arrayMaxMin);
                      $min = min($arrayMaxMin);

                      $arrayMaxMin = []; // Esvazia Array
                      $mediaX = $mediaX / count($maquinas); // (Média de os tempos)
                      $amplitudeR = ($max - $min);
                      $mediaLCx += $service->formatFloat($mediaX / count($problemas));
                      $amplitudeLCr += $amplitudeR;
                      $amplitudeLCs = $amplitudeLCr * 1.924;
                      $amplitudeLIC = $amplitudeLCr * 0.076;
                      $mediaLCs = $mediaLCx+0.419*$amplitudeLCr;
                      $mediaLIC = $mediaLCx-0.419*$amplitudeLCr;
                      
                      print '<td>'.$service->formatFloat($mediaX).'</td>'; // OKAY
                      print '<td class="mediaLCx">'.$mediaLCx.'</td>'; // okay
                      print '<td class="mediaLCs">'.$mediaLCs.'</td>'; // okay
                      print '<td class="mediaLIC">'.$mediaLIC.'</td>'; // okay
                      print '<td>'.$service->formatFloat($amplitudeR).'</td>'; // OKAY
                      print '<td class="amplitudeLCr">'.$service->formatFloat($amplitudeLCr).'</td>'; //okay
                      print '<td class="amplitudeLCs">'.$service->formatFloat($amplitudeLCs).'</td>'; // okay
                      print '<td class="amplitudeLIC">'.$service->formatFloat($amplitudeLIC).'</td>'; // pkay


                      array_push($arrayLabelGrafico, $PR_CODIGO);
                      array_push($arrayMEDIAX, $service->formatFloat($mediaX));
                      array_push($arrayLCX, $service->formatFloat($mediaLCx));
                      array_push($arrayLCS, $service->formatFloat($mediaLCs));
                      array_push($arrayLIC, $service->formatFloat($mediaLIC));

                  $flag = true;

                  print '</tr>';
                }

                $medias = $service->getMedias($problemas, $maquinas);
                  
                // Dbug
                // echo "<pre>";
                // print_r($medias);
                // echo "</pre>";

                $service->setDataLCx($medias['mediaLCx']); // Aqui seta o valor correto para LCx
                $service->setDataLCs($medias['mediaLCs']); // Aqui seta o valor correto para LCs
                $service->setDataLIC($medias['mediaLIC']); // Aqui seta o valor correto para LIC
                $service->setDataAmplitudeLCR($medias['amplitudeLCr']); // Aqui seta o valor correto para amplitude LCr
                $service->setDataAmplitudeLCs($medias['amplitudeLCs']); // Aqui seta o valor correto para amplitude LCs
                $service->setDataAmplitudeLIC($medias['amplitudeLIC']); // Aqui seta o valor correto para amplitude LIC

                    $thead .= $theadMaquinas;
                    $thead .= "<th>Media X</th>";
                    $thead .= "<th>Media LC X</th>";
                    $thead .= "<th>Media LCS</th>";
                    $thead .= "<th>Media LIC</th>";
                    $thead .= "<th>Amplitude</th>";
                    $thead .= "<th>LC R</th>";
                    $thead .= "<th>LCS</th>";
                    $thead .= "<th>LIC</th>";
                  $thead .= "</tr>";
                $thead .= "</thead>";

                print_r($thead);

              }

            ?>
          </tbody>
        </table>

        <div style="display: none" id="grafico">
          <canvas id="lineChart"></canvas>
          <span class="line">
            <style type="text/css">
              table {
                font-size: 11px;
              }

              .table-scrol{
                max-width: 100%;
                overflow-x: auto;
                height:auto; width: 1000px;
              }

              .quadrinho {
                margin: 5px;
                border-radius: 10px;
                width: 40px;
                height: 20px;
              }

              .blue {
                background: #3e95cd;
              }
              .red {
                background: #c45850;
              }
              .green {
                background: #3bba9f;
              }
              .purple {
                background: #8e5ea2;
              }

              .bord {
                margin-left: '10px'
                margin-right: '10px'
              }

              .line {
                display: -webkit-box;
              }
            </style>

            <div class="quadrinho blue"></div> <span class="bord">Média X</span> 
            <div class="quadrinho red"></div> <span class="bord">LCX</span> 
            <div class="quadrinho green"></div> <span class="bord">LCS</span>
            <div class="quadrinho purple"></div> <span class="bord">LIC</span>
          </span>
        </div>

      </div>
    </div>
  </div>
</div>
      
<!-- /page content