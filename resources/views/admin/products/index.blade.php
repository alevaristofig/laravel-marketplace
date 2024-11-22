@extends('layouts.app')
@section('content')
<table class='table table-striped'>
    <a href="{{route('admin.products.create')}}"class="btn btn-lg btn-success">Criar Produto</a>
    <thead>
        <th>#</th>
        <th>Nome</th>
        <th>Preço</th>
        <th>Loja</th>
        <th>Ações</th>        
    </thead>
    <tbody>
        @foreach($products AS $p)
            <tr>
                <td>{{$p->id}}</td>
                <td>{{$p->name}}</td>
                <td>R${{number_format($p->price,2,',','.')}}</td>
                <td>{{$p->store->name}}</td>
                <td>
                    <div class="btn-group">
                        <a href="{{route('admin.products.edit',['product' => $p->id])}}" class="btn btn-sm btn-primary">EDITAR</a>
                        <form action="{{route('admin.products.destroy',['product' => $p->id])}}" method="post">
                            @csrf
                            @method("DELETE")
                            <button type="submit" class="btn btn-sm btn-danger">APAGAR</button>
                        </form>   
                    </div>
                </td>
            </tr>
        @endforeach
        
    </tbody>
</table>

{{$products->links()}}
@endsection
