<?php 
	$html = "";

	if ($_POST) {
		$destinatarios = $_POST['emails'];
		foreach ($destinatarios as $destinatario) {
			$html .= "<tr id='$destinatario'>";
			$html .= "<td class='dest'>".$destinatario."</td>";
			$html .= "<td><button style='float: left;' id='".rand()."' class='btn btn-primary' type='button' onclick='fnHM.remove(this)' value='".$destinatario."'><span class='glyphicon glyphicon-remove'></span></button></td>";
			$html .= "</tr>";
		}
	}

	print $html;

	print_r("<style> .fade.in {
			    opacity: 1;
			    background: transparent;
			}</style>");		
?>