<?php
namespace App\Repositories;

use App\Models\PizzaOption;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Events\RepositoryEntityCreated;
use Prettus\Validator\Contracts\ValidatorInterface;

class PizzaOptionRepository extends BaseRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return PizzaOption::class;
    }

    /**
     * Validation rules
     *
     * @var array
     */
    protected $rules = [
        'create' => [
            'name' => 'required|max:255',
            'option_price' => 'required|numeric',
        ]
    ];


    public function create(array $attributes)
    {
        if (!is_null($this->validator)) {
            // we should pass data that has been casts by the model
            // to make sure data type are same because validator may need to use
            // this data to compare with data that fetch from database.
            $attributes = $this->model->newInstance()
                ->forceFill($attributes)
                ->makeVisible($this->model->getHidden())
                ->toArray();

            $this->validator->with($attributes)->passesOrFail(ValidatorInterface::RULE_CREATE);
        }

        $model = $this->model->newInstance($attributes);
        $model->save();
        $this->resetModel();

        event(new RepositoryEntityCreated($this, $model));

        return $this->parserResult($model);
    }
}