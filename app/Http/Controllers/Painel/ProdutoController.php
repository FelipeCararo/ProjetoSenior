<?php

namespace App\Http\Controllers\Painel;

use Illuminate\Http\Request;

use App\Http\Requests\Painel\ProdutoFormRequest;
use App\Http\Controllers\Controller;
use App\Model\Painel\Produto;
use App\Model\Painel\Documento;
use App\Model\Painel\Venda;

class ProdutoController extends Controller
{
    private $produtos;
    private $documentos;
    private $vendas;
    private $totalPage = 5;

    public function __construct(Produto $oProduto, Documento $oDocumento, Venda $oVenda) {
        $this->produtos   = $oProduto;
        $this->documentos = $oDocumento;
        $this->vendas     = $oVenda;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Produto $oProduto, Documento $oDocumento) {
        $title = 'Lista de Produtos';
        $produtos    = $oProduto->paginate($this->totalPage);
        $documentos  = $oDocumento->all();
        
        $ultimavenda = $this->documentos->max('numerovenda') + 1;

        return view('painel.produtos.index', compact('produtos','documentos','ultimavenda', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Cadastrar Produtos';
        //Formulario para cadastro
        return view('painel.produtos.create', compact('title'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function administrador()
    {
        $title = 'Listagem de Produtos';
 
        $aProdutos = $this->documentos
            ->leftJoin('vendas',   'documentos.numerovenda', '=', 'vendas.numerovenda_id')
            ->leftJoin('produtos', 'vendas.produto_id',      '=', 'produtos.id')
            ->where('documentos.confirmado',                 '=', 1)
            ->get();

        $iContador = $this->documentos
            ->leftJoin('vendas',   'documentos.numerovenda', '=', 'vendas.numerovenda_id')
            ->leftJoin('produtos', 'vendas.produto_id',      '=', 'produtos.id')
            ->where('documentos.confirmado',                 '=', 1)
            ->count('id');

        return view('painel.produtos.administrador', compact('iContador','aProdutos','title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function cancelar()
    {
        $title = 'Cancelamento da Venda';
 
        return view('painel.produtos.cancelar', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProdutoFormRequest $request)
    {
        /**
         * @description Pega todos os dados da requisição.
         */
        $dataForm = $request->all();

        /**
         * @description Realiza o cadastro.
         */
        $insert = $this->produtos->create($dataForm);

        if($insert){
            return redirect()->route('painel.produtos.index');
        }

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function insereVenda(){
        $sCodigos     = $_GET['sCodigo'];
        $iNumeroVenda = $_GET['iNumeroVenda'];
        $sCodigos     = str_replace('"','',$sCodigos);
        $aCodigos     = explode(',', $sCodigos);
        $sInsertVenda = '';

        unset($aCodigos[0]);

        foreach($aCodigos as $iCodigo){
            $iCodigo = str_replace(']','',$iCodigo);

            $sInsertVenda = $this->vendas->create([
                    'produto_id'     => $iCodigo,
                    'numerovenda_id' => $iNumeroVenda
            ]);

            /**
             * @description Atualiza o status Confirmado para venda.
             */
            $this->documentos->where('numerovenda', $iNumeroVenda)->update(['confirmado' => 1]);
        }

        if($sInsertVenda){
            return $this->documentos->max('numerovenda') + 1;
        }

        return 0;
    }

    public function buscaProdutos() {
        $sNome           = $_GET['sNome'];
        $bExisteProduto  = false;
        $sHtml           = '';
        $iTotal          = 0;

        $sSearchProdutos = $this->produtos->where('name', 'like','%'.$sNome.'%')->get();

        $sHtml .= "<tr>
                      <th> Nome: </th>
                      <th> Descrição: </th>
                      <th> Preço: </th>
                  </tr>";

        foreach ($sSearchProdutos as $oProduto){
            $bExisteProduto = true;
            $iTotal++;

            $sHtml .= "<tr>";
            $sHtml .= "<td hidden><input id='id_produto_".$iTotal."' type='text'     value='".$oProduto->id."' disabled='true'></td>"; 
            $sHtml .= "<td> <input type='text' style='width:150px;'                  value='".$oProduto->name."'      disabled='true'></td>"; 
            $sHtml .= "<td> <input type='text'                                       value='".$oProduto->descricao."' disabled='true'></td>";    
            $sHtml .= "<td> <input type='text' style='width:80px; text-align:right;' value='".$oProduto->preco."'     disabled='true'></td>";
            $sHtml .= "</tr>";
        }

        if(!$bExisteProduto){
            $sHtml = "<div style='text-align:center; width:400px; cursor:pointer;' class='alert alert-danger' role='alert'>Produto não cadastrado.</div>";
        }

        $insert = $this->documentos->create([
            'total'      => $iTotal,
            'confirmado' => 0
        ]);

        return $sHtml;

    }

}