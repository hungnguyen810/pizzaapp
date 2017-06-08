<?php
namespace App\Http\Controllers\User;

use ApiResponse;
use App\Libraries\GeoService\GeoService;
use App\Models\Property;
use App\Models\AVM;
use Illuminate\Http\Request;

class PropertiesController extends Controller
{
    protected $property;
    protected $avm;
    protected $model;

    public function __construct(Property $property, AVM $avm)
    {
        $this->property = $property;
        $this->avm = $avm;
        $this->model = env('DB_GET_PROPERTY_FROM') == 'mysql' ? 'property' : 'avm';
    }

    public function index(Request $request)
    {
        $this->validate($request, [
            'address'  => 'required',
            'postcode' => ['required', 'postcode_uk'],
        ]);

        $model = $this->model;

        $properties = $this->$model->searchAddressAndPostcode($request->all())->paginate();

        if ($request->ajax() || $request->wantsJson()) {
            return ApiResponse::success(\Lang::get('response.success'), $properties);
        }

        return view('user.properties.index', compact('properties'));
    }

    public function area(Request $request)
    {
        $this->validate($request, [
            'postcode' => ['required','postcode_uk'],
            'radius' => 'numeric'
        ]);

        $model = $this->model;

        $properties = $this->$model->searchInArea([
            'postcode' => $request->get('postcode'),
            'radius' => $request->get('radius')
        ]);

        if ($request->ajax() || $request->wantsJson())
            return ApiResponse::success(\Lang::get('response.success'), $properties);

        return view('user.properties.index', compact('properties'));
    }
}
