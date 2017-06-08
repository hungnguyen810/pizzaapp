<?php namespace App\Http\Controllers\Admin;

use App\Repositories\PizzaOptionRepository;
use App\Repositories\PizzaRepository;
use Illuminate\Http\Request;
use Lang;

class PizzaOptionsController extends Controller
{

    protected $pizza_option;
    protected $pizza;

    public function __construct(PizzaOptionRepository $pizza_option, PizzaRepository $pizza)
    {
        $this->pizza_option = $pizza_option;
        $this->pizza = $pizza;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.pizza-options.index', [
            'pizza_options' => $this->pizza_option->all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pizzas = $this->pizza->all()->pluck('name', 'id');
        return view('admin.pizza-options.create', compact('pizzas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->pizza_option->create($request->all());

        return redirect('/admin/pizza-options')->with('success', Lang::get('response.pizza_option.created'));
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
        return view('admin.pizza-options.edit', [
            'pizza_option' => $this->pizza_option->find($id)
        ]);
    }

    /**
     * Update pizza information
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->pizza_option->find($id);

        // Validate then remove validator
        $this->pizza_option->validator()->setRules([
            'name' => 'required|max:255',
        ])->with($request->all())->passesOrFail();
        $this->pizza_option->makeValidator(null);

        $this->pizza_option->update($request->all(), $id);

        return redirect("/admin/pizza-options/{$id}/edit")->with('statusData', Lang::get('response.pizza_option.updated'));

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
