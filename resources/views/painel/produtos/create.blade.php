@extends('painel.templates.template')

@section('content')

<fieldset style="margin-bottom: 10px; text-align: center;">
    <h1 class="tittle-pg">Cadastro de Produto</h1>
</fieldset>

@if( isset($errors) && count($errors) > 0)
<div class="alert alert-danger">
    @foreach ( $errors->all() as $error)
        <p>{{$error}}</p>
    @endforeach
</div>
@endif
<fieldset>
    <form class="form" method="post" action="{{route('painel.produtos.store')}}">
        {!! csrf_field() !!}
        <div class="form-group">
            <input type='text' name='name' placeholder="Nome:" class="form-control" value="{{old('name')}}">
        </div>
        <div class="form-group">
            <input type='number' name='preco' placeholder="Preço:" class="form-control" value="{{old('number')}}">
        </div>
        <div class="form-group">
            <textarea name='descricao' placeholder="Descrição:" class="form-control" >{{old('descricao')}}</textarea>
        </div>

        <button class="btn btn-primary">Enviar</button>
    </form>
</fieldset>
@endsection