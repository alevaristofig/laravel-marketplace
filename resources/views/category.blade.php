@extends('layouts.front')

@section('content')
    <div class="row front">
        <div class="col-12">
            <h2>{{$category->name}}</h2>
            <hr>
        </div>
        @if($category->products->count() > 0)
            @foreach($category->products AS $key => $p)
            <div class="col-md-4">
                <div class="card" style="width:98%;">
                    @if($p->photos->count() > 0)        
                        <img src="{{asset('storage/'.$p->photos->first()->image)}}" alt="" class="card-img-top"/>
                    @else
                        <img src="{{asset('assets/img/no-photo.jpg')}}" alt="" class="card-img-top"/>
                    @endif
                    <div class="card-body">
                        <h2 class="card-title">{{$p->name}}</h2>
                        <p class="card-text">{{$p->description}}</p>
                        <h3>R${{number_format($p->price,2,',','.')}}</h3>
                        <a href="{{route('product.single',['slug' => $p->slug])}}" class="btn btn-success">Ver Produto</a>
                    </div>
                </div>
            </div>

            @if(($key+1) % 3 == 0)
                </div><div class="row front">
            @endif

            @endforeach
        @else
            <div class="col-12">
                <h3 class="alert alert-warning">Nenhum produto encontrado para esta Categoria!</h3>
            </div>
        @endif
    </div>
@endsection