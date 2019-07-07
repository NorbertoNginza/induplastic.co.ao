// ****************************__ Planilhas __*********************************//
window.fnPL.viewPlanilhas = function(view, OC_CODIGO_ID) {
  var flag = 0;

  var carrega_url = view;
  carrega_url = "system/planilhas/view_planilhas/" + carrega_url + ".php";

  var dados = {flag: flag, "OC_CODIGO_ID": OC_CODIGO_ID};

  //  A função Ajax jah dah o retorno da requisição através da variavel data
  $.ajax({

      url: carrega_url,
      type: "POST",
      data: dados,

      success: function (data) {
      NProgress.start();
        $("#conteudo-page").html(data);
      },

      beforeSend: function () {

      },

      complete: function () {
        NProgress.done();
        // setTimeout(function() {fnPL.init_DataTables_Buttons()}, 50);

      }
  });
}

window.fnPL.init_DataTables_Buttons = function() {
	$('#datatable-responsive').DataTable( {
	    "language": {
	        "sEmptyTable": "Nenhum registro encontrado",
	        "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
	        "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
	        "sInfoFiltered": "(Filtrados de _MAX_ registros)",
	        "sInfoPostFix": "",
	        "sInfoThousands": ".",
	        "sLengthMenu": "_MENU_ resultados por página",
	        "sLoadingRecords": "Carregando...",
	        "sProcessing": "Processando...",
	        "sZeroRecords": "Nenhum registro encontrado",
	        "sSearch": "Pesquisar",
	        "oPaginate": {
	            "sNext": "Próximo",
	            "sPrevious": "Anterior",
	            "sFirst": "Primeiro",
	            "sLast": "Último"
	        },
	        "oAria": {
	            "sSortAscending": ": Ordenar colunas de forma ascendente",
	            "sSortDescending": ": Ordenar colunas de forma descendente"
	        }
	    },
	      dom: "Blfrtip",
		  buttons: [
			{
			  extend: "csv",
			  className: "btn-sm"
			},
			{
			  extend: "excel",
			  className: "btn-sm"
			},
			{
			  extend: "pdfHtml5",
			  className: "btn-sm"
			},
			{
			  extend: "print",
			  className: "btn-sm"
			},
		  ],
		  responsive: true
	} );
}