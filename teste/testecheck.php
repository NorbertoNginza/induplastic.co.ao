<html>
<head>
<title>Marca/Desmarca Todos CheckBoxes</title>
<!-- import maroto direto do site do jquery. recomendo FORTEMENTE vc baixar e usar localmente -->
<script language="javascript" src="http://code.jquery.com/jquery-1.7.2.js"></script>
<script type="text/javascript">
/**
* Js Função JavaScript que faz check e uncheck de todos os campos checkbox da página.
*/
function checkedOrUnCheckedAll(field) {             
    if (field.checked){//se o checkbox estiver checkado eh true
        //"input[type=checkbox]" eh o seletor do jquery, diz pro jquery procurar campos de input aonde o type eh checkbox
        $("input[type=checkbox]").attr('checked', true);//marca all check
    }else {
        $("input[type=checkbox]").attr('checked', false);//desmarca all check
    }
}
</script>
</head>

<body>
<form>

<input type="checkbox" name="allCB" onclick="checkedOrUnCheckedAll(this);" /> <b>marca/desmarca Todos</b><input value="html" type="checkbox">HTML</input><br/>
<input value="xhtml" type="checkbox">XHTML</input><br/>
<input value="CSS" type="checkbox">CSS</input><br/>

</form>
</body>
</html>