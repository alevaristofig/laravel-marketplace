@extends('layouts.front')

@section('content')
    <div class="row front">
        @foreach($products AS $key => $p)
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
    </div>
    
    <div class="row">
        <div class="col-12">
            <h2>Lojas Destaques</h2>
            <hr>
        </div>
        @foreach($stores AS $store)
            <div class="col-4">
                @if($store->logo)
                    <img src="{{asset('storage/'.$store->logo)}}" alt="Logo da Loja {{$store->name}}" class="img-fluid"/>
                @else
                    <img src="https://via.placeholder.com/450X100.png?text=logo" alt="Loja Sem Logo..." class="img-fluid"/>
                @endif
                <h3>{{$store->name}}</h3>
                <p>{{$store->description}}</p>
                <a href="{{route('store.single',$store->slug)}}" class="btn btn-sm btn-success">Ver Loja</a>
            </div>
        @endforeach
    </div>
@endsection