<?php
namespace App\Http\Controllers\User;

use ApiResponse;
use App\Models\Order;
use App\Repositories\PizzaOptionRepository;
use App\Repositories\PizzaRepository;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $order;
    protected $pizza_option;
    protected $pizza;

    public function __construct(PizzaOptionRepository $pizza_option, PizzaRepository $pizza, Order $order)
    {
        $this->pizza_option = $pizza_option;
        $this->pizza = $pizza;
        $this->order = $order;
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
        $this->validate($request, [
            'pizza_id' => 'required',
            'pizza_option_id' => 'required', //TODO: get multiples option
            'address' => 'required',
        ]);

        $pizza_price = $this->pizza->find($request->get('pizza_id'), ['price']);
        $option_price = $this->pizza_option->find($request->get('pizza_option_id'), ['option_price']);
        $total_price = $pizza_price->price + $option_price->option_price;

        if ($request->ajax() || $request->wantsJson()) {

            $order = $this->order->order($request, $total_price);

            return ApiResponse::success(\Lang::get('response.success'), $order);
        }

        return false;
    }

    /**
     * Order pizza
     *
     * @param \Illuminate\Http\Request     $request
     *
     * @return bool|mixed
     */
    public function updateStatus(Request $request)
    {
        $this->validate($request, [
            'order_id' => 'required|numeric',
            'status' => 'required'
        ]);

        if ($request->ajax() || $request->wantsJson()) {

            $order = $this->order->updateStatus($request);

            return ApiResponse::success(\Lang::get('response.success'), $order);
        }

        return false;
    }
}
