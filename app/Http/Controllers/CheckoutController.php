<?php

namespace App\Http\Controllers;

use App\User;
use App\Payment\PagSeguro\CreditCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    private $users;
    
    public function __construct() {
        $this->users = new User();
    }
    public function index()
    {
        if(!auth()->check())
        {
            return redirect()->route('login');
        }
        
        if(!session()->has('cart'))
        {
            return redirect()->route('home');
        }
        
        $this->makePagSeguroSession();

        $cardItems = array_map(function($line){
            return $line['amount'] * $line['price'];            
        }, session()->get('cart'));
       
        $cardItems = array_sum($cardItems);        
        
        echo view('checkout',compact('cardItems'));
    }
    
    public function proccess(Request $request)
    {       
        try
        {            
            $dataPost = $request->all();
        
            $user = auth()->user();
            $cardItems = session()->get('cart');
            $stores = array_unique(array_column($cardItems,'store_id'));
            $reference = 'XPTO';

            $credicCartPayment = new CreditCard($cardItems,$user,$dataPost,$reference);
            $result = $credicCartPayment->doPayment();
           
            /*$userOrder = [
                'store_id' => 43,
                'reference' => $reference,
                'pagseguro_code' => $result->getCode(),
                'pagseguro_status' => $result->getStatus(),
                'items' => serialize($cardItems)               
            ];*/
 

            $userOrder = $user->orders()->create(['store_id' => 43,
                'reference' => $reference,
                'pagseguro_code' => $result->getCode(),
                'pagseguro_status' => $result->getStatus(),
                'items' => serialize($cardItems)]);
            
            $userOrder->stores()->sync($stores);
            
            session()->forget('cart');
            session()->forget('pagseguro_session_code');

            return response()->json([
                'data' => [
                    'status' => true,
                    'message' => 'Pedido criado com Sucesso!',
                    'order' => $reference
                ]
            ]);
        }
        catch(\Exception $e)
        { 
            $message = env('APP_DEBUG') ? $e->getMessage() : 'Erro ao processar Pedido!';
            return response()->json([
                'data' => [
                    'status' => false,
                    'message' => $message
                ]
            ],401);
        }
    }
    
    public function thanks()
    {
        return view('thanks');
    }
    
    private function makePagSeguroSession()
    {
        if(!session()->has('pagseguro_session_code'))
        {
            $sessionCode = \PagSeguro\Services\Session::create(\PagSeguro\Configuration\Configure::getAccountCredentials());
            
            session()->put('pagseguro_session_code',$sessionCode->getResult());
            
            return $sessionCode->getResult();
        }                
    }
}
