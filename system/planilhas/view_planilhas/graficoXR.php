<!-- View content -->
<!-- Título padrão para Cadastros -->
<div class="" style="margin-left: 20px" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Gráficos</h3>
      </div>

    </div>

    <div class="clearfix"></div>

    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <table style="display: none;" id="datatable-responsive" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
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

                $arrayAmplitude = [];
                $arrayAmplitudeLCR = [];
                $arrayAmplitudeLCS = [];
                $arrayAmplitudeLIC = [];

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

                      // Dados para geração do gráfico de média
                      array_push($arrayLabelGrafico, $PR_CODIGO);
                      array_push($arrayMEDIAX, $service->formatFloat($mediaX));
                      array_push($arrayLCX, $service->formatFloat($mediaLCx));
                      array_push($arrayLCS, $service->formatFloat($mediaLCs));
                      array_push($arrayLIC, $service->formatFloat($mediaLIC));

                      // Dados para geração do gráfico de amplitude
                      array_push($arrayAmplitude, $service->formatFloat($amplitudeR));
                      array_push($arrayAmplitudeLCR, $service->formatFloat($amplitudeLCr));
                      array_push($arrayAmplitudeLCS, $service->formatFloat($amplitudeLCs));
                      array_push($arrayAmplitudeLIC, $service->formatFloat($amplitudeLIC));

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

                $service->dadosGrafico($arrayLabelGrafico, $arrayMEDIAX, $arrayLCX, $arrayLCS, $arrayLIC, "media");

                $service->dadosGrafico($arrayLabelGrafico, $arrayAmplitude, $arrayAmplitudeLCR, $arrayAmplitudeLCS, $arrayAmplitudeLIC, "amplitude");

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

        <div style="display: block" id="grafico">
          <canvas id="lineChart"></canvas>
          <span class="line">
            <div class="quadrinho blue"></div> <span class="bord">Média X</span> 
            <div class="quadrinho red"></div> <span class="bord">LCX</span> 
            <div class="quadrinho green"></div> <span class="bord">LCS</span>
            <div class="quadrinho purple"></div> <span class="bord">LIC</span>
          </span> <br/> <br/>
          <canvas id="lineChartAmplitude"></canvas>
          <span class="line">
            <div class="quadrinho blue"></div> <span class="bord">Amplitude R</span> 
            <div class="quadrinho red"></div> <span class="bord">LC R</span> 
            <div class="quadrinho green"></div> <span class="bord">LCS</span>
            <div class="quadrinho purple"></div> <span class="bord">LIC</span>
          </span>
        </div>

      </div>
    </div>
  </div>
</div>



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

<!-- Adicionando novos graficos -->

<div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Line Chart</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body chart-responsive1">
              <div class="chart" id="line-chart" style="height: 300px;"><svg height="300" version="1.1" width="594.6" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="overflow: hidden; position: relative; left: -0.599976px;"><desc>Created with Raphaël 2.2.0</desc><defs></defs><text style="text-anchor: end; font-family: sans-serif; font-size: 12px; font-weight: normal;" x="50.099998474121094" y="261.3999996185303" text-anchor="end" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" font-weight="normal"><tspan dy="4.400002479553223">0</tspan></text><path style="" fill="none" stroke="#aaaaaa" d="M62.599998474121094,261.3999996185303H569.6" stroke-width="0.5"></path><text style="text-anchor: end; font-family: sans-serif; font-size: 12px; font-weight: normal;" x="50.099998474121094" y="202.2999997138977" text-anchor="end" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" font-weight="normal"><tspan dy="4.399993419647217">5,000</tspan></text><path style="" fill="none" stroke="#aaaaaa" d="M62.599998474121094,202.2999997138977H569.6" stroke-width="0.5"></path><text style="text-anchor: end; font-family: sans-serif; font-size: 12px; font-weight: normal;" x="50.099998474121094" y="143.19999980926514" text-anchor="end" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" font-weight="normal"><tspan dy="4.399999618530273">10,000</tspan></text><path style="" fill="none" stroke="#aaaaaa" d="M62.599998474121094,143.19999980926514H569.6" stroke-width="0.5"></path><text style="text-anchor: end; font-family: sans-serif; font-size: 12px; font-weight: normal;" x="50.099998474121094" y="84.09999990463257" text-anchor="end" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" font-weight="normal"><tspan dy="4.399998188018799">15,000</tspan></text><path style="" fill="none" stroke="#aaaaaa" d="M62.599998474121094,84.09999990463257H569.6" stroke-width="0.5"></path><text style="text-anchor: end; font-family: sans-serif; font-size: 12px; font-weight: normal;" x="50.099998474121094" y="25" text-anchor="end" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" font-weight="normal"><tspan dy="4.399999618530273">20,000</tspan></text><path style="" fill="none" stroke="#aaaaaa" d="M62.599998474121094,25H569.6" stroke-width="0.5"></path><text style="text-anchor: middle; font-family: sans-serif; font-size: 12px; font-weight: normal;" x="476.59908837384137" y="273.8999996185303" text-anchor="middle" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" font-weight="normal" transform="matrix(1,0,0,1,0,6.8)"><tspan dy="4.400017738342285">2013</tspan></text><text style="text-anchor: middle; font-family: sans-serif; font-size: 12px; font-weight: normal;" x="251.11744119631516" y="273.8999996185303" text-anchor="middle" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" font-weight="normal" transform="matrix(1,0,0,1,0,6.8)"><tspan dy="4.400017738342285">2012</tspan></text><path style="" fill="none" stroke="#3c8dbc" d="M62.599998474121094,229.8878796693802C76.7631927853916,229.55691966991424,105.0895814079326,231.88175303196115,119.2527757192031,228.5640396715164C133.42238742708042,225.24482304267093,161.76161084283513,204.80905772032014,175.93122255071245,203.34015971221925C189.95323413663272,201.88656272503607,217.99725730847328,219.67899654783602,232.01926889439355,216.8740596903801C246.034863083707,214.0704065568864,274.0660514623339,183.70275468811144,288.08164565164736,180.90579974842072C302.24483996291787,178.07938969718563,330.57122858545887,191.4410406940478,344.73442289672937,194.38059972667696C358.9040346046067,197.32149068455877,387.24325802036134,218.39327005442075,401.41286972823866,204.42759971046448C415.43488131415893,190.60740509925773,443.4789044859995,91.95550864339486,457.5009160719198,83.23713990602494C471.36249274266936,74.61852367137091,499.08564608416845,125.37318518724157,512.947222754918,135.07965982236863C527.1104170661886,144.99734015557482,555.4368056887295,155.0702347901106,569.6,161.7337597793579" stroke-width="3"></path><circle cx="62.599998474121094" cy="229.8878796693802" r="4" fill="#3c8dbc" stroke="#ffffff" style="" stroke-width="1"></circle><circle cx="119.2527757192031" cy="228.5640396715164" r="4" fill="#3c8dbc" stroke="#ffffff" style="" stroke-width="1"></circle><circle cx="175.93122255071245" cy="203.34015971221925" r="4" fill="#3c8dbc" stroke="#ffffff" style="" stroke-width="1"></circle><circle cx="232.01926889439355" cy="216.8740596903801" r="4" fill="#3c8dbc" stroke="#ffffff" style="" stroke-width="1"></circle><circle cx="288.08164565164736" cy="180.90579974842072" r="4" fill="#3c8dbc" stroke="#ffffff" style="" stroke-width="1"></circle><circle cx="344.73442289672937" cy="194.38059972667696" r="4" fill="#3c8dbc" stroke="#ffffff" style="" stroke-width="1"></circle><circle cx="401.41286972823866" cy="204.42759971046448" r="4" fill="#3c8dbc" stroke="#ffffff" style="" stroke-width="1"></circle><circle cx="457.5009160719198" cy="83.23713990602494" r="4" fill="#3c8dbc" stroke="#ffffff" style="" stroke-width="1"></circle><circle cx="512.947222754918" cy="135.07965982236863" r="4" fill="#3c8dbc" stroke="#ffffff" style="" stroke-width="1"></circle><circle cx="569.6" cy="161.7337597793579" r="4" fill="#3c8dbc" stroke="#ffffff" style="" stroke-width="1"></circle></svg><div class="morris-hover morris-default-style" style="left: 21.4px; top: 163px; display: none;"><div class="morris-hover-row-label">2011 Q1</div><div class="morris-hover-point" style="color: #3c8dbc">
  Item 1:
  2,666
</div></div></div>
            </div>
            <!-- /.box-body -->
          </div>
      
<!-- /page content