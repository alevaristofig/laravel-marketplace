@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-12">
        <h2>Meus Pedidos</h2>
        <hr>
    </div>
    
    <div class="col-12">
        <div id="accordion">
            @forelse($userOrder AS $key => $order)
                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h5 class="mb-0">
                          <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne{{$key}}" aria-expanded="true" aria-controls="collapseOne">
                            Pedido nº: {{$order->reference}}
                          </button>
                        </h5>
                    </div>

                    <div id="collapseOne{{$key}}" class="collapse @if($key == 0)show @endif" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body">
                            <ul>
                                @php $items = unserialize($order->items) @endphp
                                @foreach($items AS $item)
                                    <li>
                                        {{$item['name']}} || R$ {{number_format($item['price'] * $item['amount'],2,'.',',')}}
                                        <br>
                                        Quantidade: {{$item['amount']}}
                                    </li>
                                    
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @empty
                <div class="alert alert-warning">Nenhum Pedido Recebido!</div>
            @endforelse
        </div>
    </div>
    
    <div class="col-12">
        <hr>
        {{$userOrder->links()}}
    </div>    
</div>


@endsection
