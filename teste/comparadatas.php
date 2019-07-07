<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<input type="date" name="" placeholder="Inicio vigencia">
	<br><br><br>
	<input type="date" name="" placeholder="Fim vigencia">
	<br><br><br>

	<button onclick="comparaDatas()">Action</button>
	

	<script type="text/javascript">
		function comparaDatas(datainicial, datafinal) {
			return (gerarData(datainicial) <= gerarData(datafinal))
		}

		function gerarData(str) {
		    var partes = str.split("/");
		    return new Date(partes[2], partes[1] - 1, partes[0]);
		}

		alert(comparaDatas('26/02/2019', '26/03/2019'));
	</script>
</body>
</html>