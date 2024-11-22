@extends('layouts.app')
@section('content')
<h1>Atualizar Produto</h1>
<form method="post" action="{{route('admin.products.update',['product' => $products->id])}}" enctype="multipart/form-data">
    @csrf
    @method("PUT")
    <div class="form-group">
        <label>Nome Produto</label>
        <input type="text" name="name" value="{{$products->name}}" class="form-control" />
    </div>
    <div class="form-group">
        <label>Descrição</label>
        <input type="text" name="description" value="{{$products->description}}" class="form-control" />
    </div>
    <div class="form-group">
        <label>Conteúdo</label>
        <textarea name="body" cols="30" rows="10" class="form-control">{{$products->body}}</textarea>
    </div>
    <div class="form-group">
        <label>Preço</label>
        <input type="text" name="price" value="{{$products->price}}" class="form-control" />
    </div>
    <div class="form-group">
        <label>Categorias</label>
        <select name="categories[]" class="form-control" multiple>
            @foreach($categories AS $c)
                <option value="{{$c->id}}"
                        @if($products->categories->contains($c)) selected @endif>
                    {{$c->name}}</option>
            @endforeach
        </select>
        @error('categories')
            <div class="invalid-feedback">
                {{$message}}
            </div>            
        @enderror
    </div>
    <div class="form-group">
        <label>Fotos do Produto</label>
        <input type="file" name="photos[]" class="form-control @error('photos.*') is-invalid @enderror" multiple/>
        @error('photos')
            <div class="invalid-feedback">
                {{$message}}
            </div>            
        @enderror
    </div>  
    <div>
        <button type="submit" class="btn btn-lg btn-success">Atualizar Produto</button>
    </div>
</form>

<hr>
<div class="row">
    @foreach($products->photos AS $photo)
    <div class="col-4 text-center">
        <img src="{{asset('storage/'.$photo->image)}}" class="img-fluid" />
        <form action="{{route('admin.photo.remove')}}" method="post">            
            @csrf
            <input type="hidden" name="photoName" value="{{$photo->image}}" />
            <button type="submit" class="btn btn-lg btn-danger">REMOVER</button>
        </form>
    </div>
    @endforeach
</div>
@endsection
