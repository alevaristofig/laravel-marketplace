@extends('layouts.app')
@section('content')
<h1>Editar Loja</h1>
<form method="post" action="{{route('admin.stores.update',['store' => $store->id])}}" enctype="multipart/form-data">
    @csrf
    @method("PUT")
    <div class="form-group">
        <label>Nome Loja</label>
        <input type="text" name="name" value="{{$store->name}}" class="form-control" />
    </div>
    <div class="form-group">
        <label>Descrição</label>
        <input type="text" name="description" value="{{$store->description}}" class="form-control" />
    </div>
    <div class="form-group">
        <label>Telefone</label>
        <input type="text" name="phone" value="{{$store->phone}}" class="form-control" />
    </div>
    <div class="form-group">
        <label>Celular/Whatsapp</label>
        <input type="text" name="mobile_phone" value="{{$store->mobile_phone}}" class="form-control" />
    </div>
    <div class="form-group">
        <p>
            <img src="{{asset('storage/'.$store->logo)}}" />
        </p>
        <label>Fotos do Produto</label>
        <input type="file" name="logo" class="form-control @error('logo') is-invalid @enderror" multiple/>
        @error('logo')
            <div class="invalid-feedback">
                {{$message}}
            </div>            
        @enderror
    </div>  
    <div>
        <button type="submit" class="btn btn-lg btn-success">Atualizar Loja</button>
    </div>
</form>
@endsection
