@extends('layouts.app')
@section('content')
<h1>Criar Produto</h1>
<form method="post" action="{{route('admin.products.store')}}" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label>Nome Produto</label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{old('name')}}" /> 
        @error('name')
            <div class="invalid-feedback">
                {{$message}}
            </div>            
        @enderror
    </div>
    <div class="form-group">
        <label>Descrição</label>
        <input type="text" name="description" class="form-control @error('description') is-invalid @enderror" value="{{old('description')}}" />
        @error('description')
            <div class="invalid-feedback">
                {{$message}}
            </div>            
        @enderror
    </div>
    <div class="form-group">
        <label>Conteúdo</label>
        <textarea name="body" cols="30" rows="10" class="form-control @error('description') is-invalid @enderror" value="{{old('body')}}"></textarea>
        @error('body')
            <div class="invalid-feedback">
                {{$message}}
            </div>            
        @enderror
    </div>
    <div class="form-group">
        <label>Preço</label>
        <input type="text" name="price" class="form-control @error('description') is-invalid @enderror" value="{{old('price')}}" />
        @error('price')
            <div class="invalid-feedback">
                {{$message}}
            </div>            
        @enderror
    </div>
    <div class="form-group">
        <label>Categorias</label>
        <select name="categories[]" class="form-control" multiple>
            @foreach($categories AS $c)
                <option value="{{$c->id}}">{{$c->name}}</option>
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
        <button type="submit" class="btn btn-lg btn-success">Criar Produto</button>
    </div>
</form>
@endsection