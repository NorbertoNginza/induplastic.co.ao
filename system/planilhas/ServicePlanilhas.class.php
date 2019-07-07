<?php 
		
	// Inicia para a pasta planilhas
	$path = '../../php/controls/Service.class.php';
	if (file_exists($path)) {
		require_once($path);
	}

	// Inicia para a pasta planilhas/view_planilhas
	$path = '../../../php/controls/Service.class.php';
	if (file_exists($path)) {
		require_once($path);
	}

	class ServicePlanilhas extends Service {

		//	construtor da classe(Default)
		function __construct() {
		
		}

		// Aqui pega a quantidade de ocorrências
		function totalOcorrências() {
			$this->openRequisitionDb();
			$db = new Db();

			$sql = "SELECT COUNT(`OC_CODIGO`) AS total FROM `ocorrencias` WHERE 1";

			return $db->execSql($sql);
		}

		// Aqui pega a maquina com a qunatidade de horas
		function totalMinutosMaquina($OC_MAQUINA_ID, $OC_PROBLEMA_ID) {
			$this->openRequisitionDb();
			$db = new Db();

			$sql = "SELECT SUM(OC_TEMPO) AS total FROM `ocorrencias` WHERE OC_MAQUINA = $OC_MAQUINA_ID AND OC_PROBLEMA = $OC_PROBLEMA_ID GROUP BY (`OC_PROBLEMA`)";

			$result = $db->execSql($sql);

			if ($result) {
				return $result[0]['total'];
			} else {
				return 0;
			}
		}

		// Aqui pega o valor Maximo da quantidade de horas
		function maxMinutosMaquina($OC_PROBLEMA_ID) {
			$this->openRequisitionDb();
			$db = new Db();

			$sql = "SELECT MAX(OC_TEMPO) AS max FROM `ocorrencias` WHERE OC_PROBLEMA = $OC_PROBLEMA_ID GROUP BY (`OC_PROBLEMA`)";

			$result = $db->execSql($sql);

			if ($result) {
				return $result[0]['max'];
			} else {
				return 0;
			}
		}

		// Aqui pega o valor minimo da quantidade de horas
		function minMinutosMaquina($OC_PROBLEMA_ID) {
			$this->openRequisitionDb();
			$db = new Db();

			$sql = "SELECT MIN(OC_TEMPO) AS min FROM `ocorrencias` WHERE  OC_PROBLEMA = $OC_PROBLEMA_ID GROUP BY (`OC_PROBLEMA`)";

			$result = $db->execSql($sql);

			if ($result) {
				return $result[0]['min'];
			} else {
				return 0;
			}
		}

		// Retorn um array com os dados dos problemas
		public function getProblemas() {
			$this->openRequisitionDb();
			$db = new Db();

			$sql = "SELECT * FROM `problemas`  
							ORDER BY PR_CODIGO ASC";

			return $db->execSql($sql);
		}


		function dadosGrafico($arrayLabelGrafico, $arrayMEDIAX, $arrayLCX, $arrayLCS, $arrayLIC, $flag) {
			// DBUG
			// echo "<pre>";
			// print_r($arrayLabelGrafico);
			// print_r($arrayMEDIAX);
			// print_r($arrayLCX);
			// print_r($arrayLCS);
			// print_r($arrayLIC);
			// echo "</pre>";
			// return false;

			// $labels: ["A1", "A2", "A3", "A4", "A5", "A6", "A7", "A8", "A9", "A10"];
			$labels = "labels = [";
			$dataMediax = "[";
			$dataLCX = "[";
			$dataLCS = "[";
			$dataLIC = "[";
			$max = count($arrayLabelGrafico);
			for ($i=0; $i < $max; $i++) {
				if ($i != $max - 1) {
					$labels .= "'".$arrayLabelGrafico[$i]."', ";
					$dataMediax .= "'".$arrayMEDIAX[$i]."', ";
					$dataLCX .= "'".$arrayLCX[count($arrayLCX) - 1]."', ";
					$dataLCS .= "'".$arrayLCS[count($arrayLCS) - 1]."', ";
					$dataLIC .= "'".$arrayLIC[count($arrayLIC) - 1]."', ";
				} else {
					$labels .= "'".$arrayLabelGrafico[$i]."'";
					$dataMediax .= "'".$arrayMEDIAX[$i]."'";
					$dataLCX .= "'".$arrayLCX[count($arrayLCX) - 1]."'";
					$dataLCS .= "'".$arrayLCS[count($arrayLCS) - 1]."'";
					$dataLIC .= "'".$arrayLIC[count($arrayLIC) - 1]."'";
				}
			}
			$labels .= "]";
			$dataMediax .= "]";
			$dataLCX .= "]";
			$dataLCS .= "]";
			$dataLIC .= "]";

			$data = "data = [{ 
	                    data: $dataMediax,
	                    label: 'Media X',
	                    borderColor: '#3e95cd',
	                    fill: false
	                  }, { 
	                    data: $dataLIC,
	                    label: 'LIC',
	                    borderColor: '#8e5ea2',
	                    fill: false
	                  }, { 
	                    data: $dataLCS,
	                    label: 'LCS',
	                    borderColor: '#3cba9f',
	                    fill: false
	                  }, { 
	                    data: $dataLCX,
	                    label: 'LCX',
	                    borderColor: '#c45850',
	                    fill: false
	                  }]";

	        // DBUG
	        // print_r($labels);
	        // echo "<br>";
	        // print_r($dataLCX);
	        // echo "<br>";
	        // print_r($dataLCS);
	        // echo "<br>";
	        // print_r($dataMediax);
	        // echo "<br>";
	        // print_r($dataLIC);
	        // echo "<br>";

            $this->printGrafico($labels, $data, $flag);
		}

		// Exibe o gráfico na pagina
		private function printGrafico($labels, $data, $flag) {
			if ($flag == "media") {
				$id = "lineChart";
				$title = "Carta de controle de Média";
			} else {
				$id = "lineChartAmplitude";
				$title = "Carta de controle de Amplitude";
			}
			echo "<script>
            		$labels;
            		$data;

            		new Chart(document.getElementById('$id'), {
		                type: 'line',
		                data: {
		                  labels: labels,
		                  datasets: data
		                },
		                options: {
		                  title: {
		                    display: true,
		                    text: '$title'
		                  }
		                }
		              });

            	 </script>";
		}

		public function getMedias($problemas, $maquinas) {
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
              $PR_CODIGO = "A".$this->ajustAtribute($problema['PR_CODIGO']);
              $PR_DESCRICAO = $this->ajustAtribute($problema['PR_DESCRICAO']);

              
                foreach ($maquinas as $maquina) {
                    $tempo = $this->totalMinutosMaquina($maquina['MA_CODIGO'], $problema['PR_CODIGO']);
                    $mediaX += $tempo;
                    array_push($arrayMaxMin, $tempo);

                }
                  // $max = $this->maxMinutosMaquina($problema['PR_CODIGO']);
                  // $min = $this->minMinutosMaquina($problema['PR_CODIGO']);
                  $max = max($arrayMaxMin);
                  $min = min($arrayMaxMin);

                  $arrayMaxMin = []; // Esvazia Array

                  $mediaX = $mediaX / count($maquinas); // (Média de os tempos)
                  $mediaLCx += $this->formatFloat($mediaX / count($problemas));
                  $amplitudeR = ($max - $min);
                  $amplitudeLCr += $amplitudeR / count($problemas);
                  $mediaLCs = $mediaLCx+0.419*$amplitudeLCr;
                  $mediaLIC = $mediaLCx-0.419*$amplitudeLCr;

            }

            $medias["mediaLCs"] = $mediaLCs;
            $medias["mediaLCx"] = $mediaLCx;
            $medias["mediaLIC"] = $mediaLIC;
            $medias["amplitudeLCr"] = $amplitudeLCr;
            $medias["amplitudeLCs"] = $amplitudeLCr * 1.924;
            $medias["amplitudeLIC"] = $amplitudeLCr * 0.076;

            return $medias;
		}

		public function setDataLCs($mediaLCs) {
			echo "<script>
					$('.mediaLCs').html('$mediaLCs');	
				 </script>";
		}

		public function setDataLCx($mediaLCx) {
			echo "<script>
					$('.mediaLCx').html('$mediaLCx');	
				 </script>";
		}

		public function setDataLIC($mediaLIC) {
			echo "<script>
					$('.mediaLIC').html('$mediaLIC');	
				 </script>";
		}

		public function setDataAmplitudeLCR($amplitudeLCR) {
			echo "<script>
					$('.amplitudeLCr').html('$amplitudeLCR');	
				 </script>";
		}

		public function setDataAmplitudeLCs($amplitudeLCs) {
			echo "<script>
					$('.amplitudeLCs').html('$amplitudeLCs');	
				 </script>";
		}

		public function setDataAmplitudeLIC($amplitudeLIC) {
			echo "<script>
					$('.amplitudeLIC').html('$amplitudeLIC');	
				 </script>";
		}
		
	}

?>
