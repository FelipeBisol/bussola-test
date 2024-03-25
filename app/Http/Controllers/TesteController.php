<?php

namespace App\Http\Controllers;

use App\Repositories\CartItem\CartItemRepository;
use Core\Modules\ShoppingCart\CalculateCartUseCase;

class TesteController extends Controller
{
    public function index()
    {
        $useCase = new CalculateCartUseCase(new CartItemRepository());

    }
}
