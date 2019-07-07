<!-- The Modal -->
<div id="modalCaixaEmail" class="modalCaixaEmail" style="display: none;">
  <!-- Modal content -->
  <div class="modalCaixaEmail-content">
    <!-- Modal Header -->
    
    <div class="modalCaixaEmail-header">
      <h4 class="titleModalCaixaEmail"><b>Enviar Lembrete</b></h4>
      <span onclick="fnHM.closeModalCaixaEmail()" class="closeModalCaixaEmail">&times;</span>
    </div>

    <form>
      <div class="form-group row">
          <label style="margin: 10px; margin-right: 0px;" for="destinatario-caixa-email" class="col-sm-1 col-form-label col-form-label-sm">Para</label>
          <div class="col-sm-7">
            <div class="input-group mb-3">
              <input onchange="fnHM.addEmailTable()" maxlength="50" style="margin-bottom: 8px;" type="text" class="form-control form-control-sm" id="destinatario-caixa-email" placeholder="Destinatário">
              <div class="input-group-append">
                <button style="margin-left: 5px;" data-toggle="modal" data-target=".dialog-home" onclick="fnCC.listClientes()" type="button" class="btn btn-round btn-warning">Clintes</button>
              </div>
            </div>

            <style type="text/css">
              .input-group {
                display: -webkit-inline-box;
              }
            </style>
            <input type="text" class="form-control form-control-sm" maxlength="100" id="assunto-caixa-email" placeholder="Assunto">
          </div>
          <div class="col-sm-2 table-responsive-xl">
            <table id="table-destinatarios" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th><label>Destinatário(s)</label></th>
                  <th><label></label></th>
                </tr>
              </thead>

              <tbody id="conteudo-table-destinatarios">
                <tr>
                  <style type="text/css">
                    .btn-email {
                      background: #2A3F54;
                    }
                  </style>
                  <!-- <td class="dest">emissao@maxximusbank.com.br</td> -->
                  <!-- <td><button id='send-email' class='btn btn-primary btn-email' type='button' onclick='fn.remove(this)' value='' style='float: left; background: #2A3F54;' ><span class='glyphicon glyphicon-remove'></span></button></td>-->
                </tr>
              </tbody>

            </table>
          </div>

          <div class="col-sm-11">
              <textarea style="margin: 20px;" rows="5" type="text" maxlength="100" class="form-control form-control-sm" id="mensagem-caixa-email" placeholder="Mensagem"></textarea> 
          </div>

      </div>
    </form>

    <!-- Modal content -->
    <div class="modalCaixaEmail-footer">
      <div class="col-sm-12">
        <button style="float: right;" onclick='fnCC.enviaEmail()' class="btn btn-primary btn-xs\" type='button'><span class="glyphicon glyphicon-send"></span> Enviar</button>
      </div>

<!--       <div class="col-sm-2">
        <a onclick="fn.createViewPdf()"><span class="glyphicon glyphicon-file"></span><span style="position: absolute; float: left;"> baixacontratos.pdf</span></a>
      </div> -->
    </div>
  </div>

</div>
