<?php namespace App\Http\Controllers\Admin;

use App\Repositories\PizzaOptionRepository;
use App\Repositories\PizzaRepository;
use App\Repositories\OrderRepository;
use Illuminate\Http\Request;
use Lang;

class OrdersController extends Controller
{

    protected $pizza_option;
    protected $pizza;
    protected $order;

    public function __construct(PizzaOptionRepository $pizza_option, PizzaRepository $pizza, OrderRepository $order)
    {
        $this->pizza_option = $pizza_option;
        $this->pizza = $pizza;
        $this->order = $order;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.orders.index', [
            'orders' => $this->order->with('user')->with('pizza')->with('pizza_option')->all()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('admin.orders.edit', [
            'orders' => $this->order->find($id)
        ]);
    }

    /**
     * Update order information
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->order->find($id);

        // Validate then remove validator
        $this->order->validator()->setRules([
            'status' => 'required|max:255',
        ])->with($request->all())->passesOrFail();
        $this->order->makeValidator(null);

        $this->order->update($request->all(), $id);

        return redirect("/admin/orders/{$id}/edit")->with('statusData', Lang::get('response.order.updated'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
