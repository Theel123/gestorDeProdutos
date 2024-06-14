<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *   version="1.0.0",
 *   title="Gestor De Pedidos"
 * )
 */

class Controller extends BaseController
{
    use AuthorizesRequests;
    use ValidatesRequests;
}
