<?php namespace App\Http\Controllers\Admin;

use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Lang;

class UsersController extends Controller
{

    protected $user;

    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.users.index', [
            'users' => $this->user->all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
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
        $this->user->create($request->all());

        return redirect('/admin/users')->with('success', Lang::get('response.user.created'));
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
        return view('admin.users.edit', [
            'user' => $this->user->find($id)
        ]);
    }

    /**
     * Update user information
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->user->find($id);

        // Validate then remove validator
        $this->user->validator()->setRules([
            'name' => 'sometimes|required|max:255',
            'email' => 'sometimes|email|max:255|unique:users,email,' . $id,
        ])->with($request->all())->passesOrFail();
        $this->user->makeValidator(null);

        $this->user->update($request->all(), $id);

        return redirect("/admin/users/{$id}/edit")->with('statusData', Lang::get('response.user.updated'));

    }

    public function updatePassword(Request $request, $id)
    {
        $this->user->find($id);

        // Validate
        // TODO: Change to use Validtion service
        $this->user->validator()->setRules([
            'password' => 'required|min:6|confirmed',
        ])->with($request->all())->passesOrFail();

        $this->user->update(['password' => bcrypt($request->get('password'))], $id);

        return redirect("/admin/users/{$id}/edit")
            ->with('statusPassword', Lang::get('response.user.updated-password'));
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
