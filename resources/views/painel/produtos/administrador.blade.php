@extends('painel.templates.template')

@section('content')

<fieldset style="margin-bottom: 10px;">
    <h1 class="tittle-pg">Listagem de Produtos Vendidos</h1>
</fieldset>

<fieldset>
    <table>
        <tr>
            <th>Nome:</th>
            <th>Descrição:</th>
        </tr>
        @foreach($aProdutos as $aProduto)
        <tr>
            <td>{{$aProduto->name}}</td>
            <td>{{$aProduto->descricao}}</td>
        </tr>
        @endforeach

    </table>
</fieldset>
<fieldset style="margin-top: 10px; ">
    <b>Total Vendido:</b> {{$iContador}}
</fieldset>

@endsection