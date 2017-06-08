<?php namespace App\Http\Controllers\Admin;

use App\Repositories\PizzaRepository;
use Illuminate\Http\Request;
use Lang;

class PizzasController extends Controller
{

    protected $pizza;

    public function __construct(PizzaRepository $pizza)
    {
        $this->pizza = $pizza;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.pizzas.index', [
            'pizzas' => $this->pizza->all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pizzas.create');
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
        $this->pizza->create($request->all());

        return redirect('/admin/pizzas')->with('success', Lang::get('response.pizza.created'));
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
        return view('admin.pizzas.edit', [
            'pizza' => $this->pizza->find($id)
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
        $this->pizza->find($id);

        // Validate then remove validator
        $this->pizza->validator()->setRules([
            'name' => 'required|max:255',
        ])->with($request->all())->passesOrFail();
        $this->pizza->makeValidator(null);

        $this->pizza->update($request->all(), $id);

        return redirect("/admin/pizzas/{$id}/edit")->with('statusData', Lang::get('response.pizza.updated'));

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
