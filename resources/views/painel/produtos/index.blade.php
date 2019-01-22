@extends('painel.templates.template')

@section('content')
<fieldset >
<div class="row">
    <div class="col-sm-1"></div>
    <label class="col-md-2">Venda Atual:</label>
    <label style="margin-left: -90px;" id="ultima-venda">{{$ultimavenda}}</label>
</div>
<div class="row">
    <div class="col-sm-1"></div>
    <label class="col-md-6">Lista de produtos:</label>
    <label class="col-md-5">Produto:</label>
</div>
<div class="row" style="padding-left: 10px; padding-bottom: 10px;">
    <div class="col-md-6">
        <fieldset style="height: 400px; width: 100%;">
            <table id="tabela-produto" class="table table-striped">
                <tr>
                    <th>Nome: </th>
                    <th>Descrição: </th>
                    <th>Preço: </th>
                </tr>
            </table>
        </fieldset>
    </div>
    <div class="col-md-4" >
        <input id="search-id" size="74%" type="text" name='search' value="">
    </div>
    <div  class="col-sm-2" style="margin-top:45px; padding-left: 100px;">
        <button style="width:83px;" class="btn btn-primary" onclick="buscaProduto()">OK</button>
    </div>
</div>
    <!-- Caso necessite paginação -->
    <!--{!! $produtos->links() !!}-->
<div class="row">
    <div class="col-md-8" style="margin-left: 20px;">
        <a class="btn btn-primary" href="{{url('painel/produtos/cancelar')}}" role="button">Cancelar</a>
    </div>
    <div class="col-sm-2">
        <button style="margin-left:265px;" class="btn btn-primary" onclick="confirmaVenda()">Confirmar</button>
    </div>
</div>
</fieldset>
<div id="mensagem" style="text-align: center; margin-left: 300px; margin-top: 10px;" onclick="limpaMensagem()"></div>
    <script>
        function buscaProduto(){
           let sNome          = $('#search-id').val(),
               sMensagemAviso = "<div style='width:400px; cursor:pointer;' class='alert alert-danger' role='alert'>O campo Produto está em branco.</div>";

           if(sNome == ''){
               $("#mensagem").html(sMensagemAviso);
           }
           else {
            $.ajax({
                    url:  'produtos/buscaProdutos',
                    type: 'GET',
                    data: {
                        sNome:  sNome
                    },
                success: function(sRetorno){
                    limpaMensagem();
                    $("#tabela-produto").html(sRetorno);
            }});
           }
        }

        function confirmaVenda(){
            let aCodigos  = [],
                iNumeroVenda = $('#ultima-venda').html(),
                sMensagem = '';

            $('#tabela-produto tr').each(function(i){
                if(i > 0){
                    aCodigos[i] = $('#id_produto_'+i).val();
                }
            })

            let sCodigos = JSON.stringify(aCodigos);

            $.ajax({
                    url:  'produtos/insereVenda',
                    type: 'GET',
                    data: {
                        sCodigo:      sCodigos,
                        iNumeroVenda: iNumeroVenda
                    },
                success: function(iRetorno){
                    if(iRetorno){
                        atualizaVendaAtual(iRetorno);
                        limpaCampoProduto();
                        limpaListaProduto();
                        sMensagem = '<div style="cursor:pointer;" class="alert alert-success" role="alert">Venda realizada com sucesso.</div>';
                        addMensagem(sMensagem);
                    }
                    else {
                        limpaCampoProduto();
                        limpaListaProduto();
                        sMensagem = "<div style='cursor:pointer;' class='alert alert-danger' role='alert'>Erro ao efetuar venda.</div>";
                        addMensagem(sMensagem);
                    }
            }});

        }

        function limpaCampoProduto(){
            $('#search-id').val('');
        }

        function limpaListaProduto(){
            $('#tabela-produto').html('');
        }

        function atualizaVendaAtual(iVendaAtual){
            $('#ultima-venda').html(iVendaAtual);
        }

        function addMensagem(sMensagem){
            $("#mensagem").html(sMensagem);
        }

        function limpaMensagem(){
            $("#mensagem").html('');
        }
    </script>
@endsection