<?php
namespace App\Http\Controllers\User;

use ApiResponse;
use App\Repositories\PizzaOptionRepository;
use App\Repositories\PizzaRepository;
use Illuminate\Http\Request;

class PizzasController extends Controller
{
    protected $pizza_option;
    protected $pizza;

    public function __construct(PizzaOptionRepository $pizza_option, PizzaRepository $pizza)
    {
        $this->pizza_option = $pizza_option;
        $this->pizza = $pizza;
    }

    /**
     * Order pizza
     *
     * @param \Illuminate\Http\Request     $request
     *
     * @return bool|mixed
     */
    public function index(Request $request)
    {

        if ($request->ajax() || $request->wantsJson()) {

            $order = $this->pizza->with('pizza_option')->all();

            return ApiResponse::success(\Lang::get('response.success'), $order);
        }

        return false;
    }
}
