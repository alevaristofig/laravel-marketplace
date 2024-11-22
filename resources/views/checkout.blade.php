@extends('layouts.front')

@section('stylesheets')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
@endsection

@section('content')

    <div class="container">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12">
                    <h2>Dados para o pagamento!</h2>
                    <hr>
                </div>
            </div>
            <form action="" method="post">
                <div class="row">
                     <div class="form-group col-md-12">
                        <label>Nome no Cartão</label>
                        <input type="text" class="form-control" name='card_name'/>                        
                    </div>
                    <div class="form-group col-md-12">
                        <label>Número do Cartão <span class="brand"></span></label>
                        <input type="text" class="form-control" name='card_number'/>
                        <input type="hidden" name="card_brand" value="" />
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <label>Mês de Expiração</label>
                        <input type="text" class="form-control" name='card_month'/>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Ano de Expiração</label>
                        <input type="text" class="form-control" name='card_year'/>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-5">
                        <label>Código de Segurança</label>
                        <input type="text" class="form-control" name='card_cvv'/>
                    </div>   
                    
                    <div class="col-md-12 installments form-group"></div>
                </div>

                <button class="btn btn-lg btn-success processCheckout">Efetuar Pagamento</button>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>    
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>    
    
    <script>
        const SessionId = '{{session()->get('pagseguro_session_code')}}';
        PagSeguroDirectPayment.setSessionId(SessionId);        
    </script>
    
    <script>
        let amountTransaction = '{{$cardItems}}';
        let cardNumber = document.querySelector('input[name=card_number]');
        let spanBrand = document.querySelector('span.brand');
        
        cardNumber.addEventListener('keyup',function(){
            if(cardNumber.value.length >= 6)
            {
                PagSeguroDirectPayment.getBrand({
                    cardBin: cardNumber.value.substr(0,6),
                    success: function(resp){
                        let imgFlag = '<img src="https://stc.pagseguro.uol.com.br/public/img/payment-methods-flags/68x30/'+resp.brand.name+'.png">';
                        document.querySelector('input[name=card_brand]').value = resp.brand.name;
                        spanBrand.innerHTML = imgFlag;
                        
                        getInstallments(amountTransaction,resp.brand.name);
                    },
                    error: function(err){
                        console.log(err);
                    },
                    complete: function(resp){
                       // console.log('Complete: ', resp); 
                        //spanBrand.innerHTML = resp;
                    }
                });
            }            
        });
        
        let submitButton = document.querySelector('button.processCheckout');
        
        submitButton.addEventListener('click',function(event){
           
            event.preventDefault();
      
            PagSeguroDirectPayment.createCardToken({
                cardNumber: document.querySelector('input[name=card_number]').value,
                brand:  document.querySelector('input[name=card_brand]').value,
                cvv:    document.querySelector('input[name=card_cvv]').value,
                expirationMonth: document.querySelector('input[name=card_month]').value,
                expirationYear:  document.querySelector('input[name=card_year]').value,
                success: function(resp){                    
                    processPayment(resp.card.token);
                },               
                error: function(err){
                        console.log(err);
                },
            });
        });
        
        function processPayment(token)
        {
            let data = {
                    card_token: token,
                    hash: PagSeguroDirectPayment.getSenderHash(),
                    installment: document.querySelector('.select_installments').value,
                    card_name:  document.querySelector('input[name=card_name]').value,
                    _token: '{{csrf_token()}}'
            };
            
            $.ajax({
                type: 'post',
                url:'{{route("checkout.proccess")}}',
                data: data,
                dataType: 'json',
                success: function(resp){                      
                    toastr.success(resp.data.message, 'Sucesso');
                    window.location.href = '{{route('checkout.thanks')}}?order='+resp.data.order;
                }               
            });
        }
        
        function getInstallments(amount,brand)
        {
            PagSeguroDirectPayment.getInstallments({
                amount: amount,
                brand: brand,
                maxInstallmentsNoInterest: 0,
                success: function(resp){
                    let selectInstallments = drawSelectInstallments(resp.installments[brand]);
                    document.querySelector('div.installments').innerHTML = selectInstallments;
                },
                error: function(err){
                    console.log(err);
                },
                complete: function(resp){}                                     
            });
        }
        
        function drawSelectInstallments(installments) 
        {
            let select = '<label>Opções de Parcelamento:</label>';

            select += '<select class="form-control select_installments">';

            for(let l of installments) {
                select += `<option value="${l.quantity}|${l.installmentAmount}">${l.quantity}x de ${l.installmentAmount} - Total fica ${l.totalAmount}</option>`;
            }


            select += '</select>';

            return select;
	}
    </script>
@endsection
