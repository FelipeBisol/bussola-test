<?php

namespace App\Console\Commands;

use Core\Modules\Payment\Collections\CartItemCollection;
use Core\Modules\Payment\Entities\Cart;
use Core\Modules\Payment\Entities\CartItem;
use Core\Modules\Payment\Entities\CreditCard;
use Core\Modules\Payment\Entities\Installment;
use Core\Modules\Payment\Enum\PaymentMethod;
use Core\Modules\Payment\Enum\Products;
use Core\Modules\Payment\Exceptions\InstallmentException;
use Core\Modules\Payment\Gateway\PaymentMethods\CreditCardPayment;
use Core\Modules\Payment\Gateway\PaymentMethods\CreditCashPayment;
use Core\Modules\Payment\Gateway\PaymentMethods\PixPayment;
use Core\Modules\Payment\Gateway\PaymentProcess;
use Core\Modules\Payment\UseCases\ProcessCreditCardPayment;
use Core\Modules\Payment\UseCases\ProcessCreditCashPayment;
use Core\Modules\Payment\UseCases\ProcessPixPayment;
use Illuminate\Console\Command;

class NewOrderCommand extends Command
{
    protected $signature = 'new:order';

    protected $description = 'Command description';

    /**
     * @throws InstallmentException
     */
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
            $installments = new Installment($this->ask('Em quantas prestações pretende pagar?'));
        }

        $paymentProcessor = match ($payment_method){
            PaymentMethod::Pix->getName() => new ProcessPixPayment(new PixPayment($cart)),
            PaymentMethod::CreditCash->getName() => new ProcessCreditCashPayment(new CreditCashPayment($cart, $card)),
            PaymentMethod::CreditCard->getName() => new ProcessCreditCardPayment(new CreditCardPayment($cart, $card, $installments)),
        };

        $paymentProcessor->process();

        $this->alert($paymentProcessor->getResponse());
    }
}
