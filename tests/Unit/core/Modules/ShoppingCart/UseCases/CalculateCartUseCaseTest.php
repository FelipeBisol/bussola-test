<?php

namespace Tests\Unit\core\Modules\ShoppingCart\UseCases;

use App\Entities\CartItem;
use Core\Modules\ShoppingCart\CalculateCartUseCase;
use Core\Modules\ShoppingCart\Collections\CartItemCollection;
use Core\Modules\ShoppingCart\Gateway\CartItemRepositoryInterface;
use Core\Modules\ShoppingCart\Inputs\ItemCartIdInput;
use Tests\TestCase;

class CalculateCartUseCaseTest extends TestCase
{
    public function test_calculate_cart_use_case()
    {
        //arrange
        $itemCartIdInput = $this->createMock(ItemCartIdInput::class);
        $itemCartIdInput->method('getId')->willReturn(1);
        $repository = $this->createMock(CartItemRepositoryInterface::class);

        $collection = new CartItemCollection();
        $items = [
            0 => new CartItem('Fone de ouvido', random_int(1000, 9999), random_int(1, 5)),
            1 => new CartItem('Base carregadora', random_int(1000, 9999), random_int(1, 5)),
            2 => new CartItem('Pilhas', random_int(1000, 9999), random_int(1, 5))
        ];

        $expectedValue = 0;

        foreach ($items as $item) {
            $expectedValue += $item->getPrice() * $item->getQuantity();
            $collection->add($item);
        }

        $repository->method('getCartItem')->willReturn($collection);
        $useCase = new CalculateCartUseCase($repository);

        //act
        $useCase->execute($itemCartIdInput);
        $response = $useCase->getOutput()->getPresenter()->toArray();

        //assert
        $this->assertEquals([
            "status" => [
                "code" => 200,
                "message" => "Success",
            ],
            "data" => [
                "total" => $expectedValue
            ]
        ], $response);
    }
}
