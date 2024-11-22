@extends('layouts.front')

@section('content')
    <div class="row front">        
        <div class="col-4">
            @if($store->logo)
               <img src="{{asset('storage/'.$store->logo)}}" alt="Logo da Loja {{$store->name}}" class="img-fluid"/>
            @else
               <img src="https://via.placeholder.com/450X100.png?text=logo" alt="Loja Sem Logo..." class="img-fluid"/>
            @endif
        </div>
        <div class="col-4">
            <h2>{{$store->name}}</h2>
            <p>{{$store->description}}</p>
            <p>
                <strong>Contatos</strong>
                <span>{{$store->phone}}</span> | <span>{{$store->mobile_phone}}</span>
            </p>
        </div>                  
        <div class="col-12">
            <hr>  
            <h3 style="margin-bottom: 30px;">Produtos desta Loja</h3>
        </div>
        @if($store->products->count() > 0)
            @foreach($store->products AS $key => $p)
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
                <h3 class="alert alert-warning">Nenhum produto encontrado para esta Loja!</h3>
            </div>
        @endif
    </div>
@endsection