<?php

namespace App\Console\Commands;

use Core\Collections\CartItemCollection;
use Core\Entities\Cart;
use Core\Entities\CartItem;
use Core\Entities\CreditCard;
use Core\Enum\PaymentMethod;
use Core\Enum\Products;
use Core\Gateway\PaymentMethods\CreditCardPayment;
use Core\Gateway\PaymentMethods\CreditCashPayment;
use Core\Gateway\PaymentMethods\PixPayment;
use Core\Gateway\PaymentProcess;
use Illuminate\Console\Command;

class NewOrderCommand extends Command
{
    protected $signature = 'new:order';

    protected $description = 'Command description';

    public function handle(): void
    {
        $products = [];
        $moreProducts = true;

        while ($moreProducts) {
            $product = $this->choice(
                'Qual produto está comprando?',
                [
                    Products::Camiseta->getName(),
                    Products::Colar->getName(),
                    Products::Relogio->getName()
                ]
            );

            $price = $this->ask('Qual é o preço do produto?');

            $products[] = [
                'name' => $product,
                'price' => $price,
            ];

            $moreProducts = $this->confirm('Deseja adicionar outro produto?', true);
        }

        $items = new CartItemCollection();

        foreach ($products as $product) {
            $item = new CartItem($product['name'], $product['price'] * 100,1);
            $items->add($item);
        }

        $cart = new Cart($items);

        $payment_method = $this->choice(
            'Qual o método de pagamento?',
            [
                PaymentMethod::Pix->getName(),
                PaymentMethod::CreditCash->getName(),
                PaymentMethod::CreditCard->getName()
            ]
        );

        if ($payment_method === PaymentMethod::Pix->getName()){
            $this->info('Conseguimos um desconto de 10% para a sua compra!');
        }else{
            $owner_name = $this->ask('Informe o nome do titular do cartão');
            $number = $this->ask('Informe o número do cartão');
            $due_date = $this->ask('Informe a data de vencimento');
            $security_code = $this->ask('Informe o CVV do cartão');
            $card = new CreditCard($owner_name, $number, $due_date, $security_code);
        }

        if ($payment_method === PaymentMethod::CreditCard->getName()){
            $installments = $this->ask('Em quantas prestações pretende pagar?');
        }

        $method = match ($payment_method){
            PaymentMethod::Pix->getName() => new PixPayment($cart),
            PaymentMethod::CreditCash->getName() => new CreditCashPayment($cart, $card),
            PaymentMethod::CreditCard->getName() => new CreditCardPayment($cart, $card, $installments),
        };

        $paymentProcess = new PaymentProcess($method);
        $this->alert('O valor total da compra é: R$' . number_format($paymentProcess->process() / 100, 2, ',', '.'));
    }
}
