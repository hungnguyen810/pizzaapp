<?php namespace App\Libraries\Validator;

use Exception;
use Illuminate\Support\MessageBag;
use Illuminate\Validation\Factory as LaravelValidator;
use Prettus\Validator\Exceptions\ValidatorException;

abstract class AbstractValidator implements ValidatorInterface
{
    /**
     * Data to be validated
     *
     * @var array
     */
    protected $data = array();

    /**
     * Validator object
     *
     * @var LaravelValidator
     */
    protected $validator;

    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = array();

    /**
     * Validation errors
     *
     * @var MessageBag
     */
    protected $errors;

    /**
     * AbstractValidator constructor.
     *
     * @param \Illuminate\Validation\Factory $validator
     */
    public function __construct(LaravelValidator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Add data to validation against
     *
     * @param array
     * @return AbstractValidator
     */
    public function with(array $data) {
        $this->data = $data;

        return $this;
    }

    /**
     * Pass the data and the rules to the validator
     *
     * @param string $action
     * @return boolean
     */
    public function passes($action = null) {

        $validator = $this->validator->make($this->data, $this->getRules($action));

        if ($validator->fails()) {
            $this->errors = $validator->messages();
            return false;
        }

        return true;
    }

    /**
     * Pass the data and the rules to the validator or throws ValidatorException
     *
     * @param string $action
     * @return bool
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function passesOrFail($action = null) {

        if (!$this->passes($action))
            throw new ValidatorException($this->errorsBag());

        return true;
    }

    /**
     * Retrive validation errors array
     *
     * @return array
     */
    public function errors() {
        return $this->errorsBag()->all();
    }

    /**
     * Retrive validation errors bag
     *
     * @return MessageBag
     */
    public function errorsBag() {
        return $this->errors;
    }

    /**
     * Set rules on-fly for validation
     *
     * @param array $rules
     * @return $this
     */
    public function setRules(array $rules) {
        $this->rules = $rules;

        return $this;
    }

    /**
     * Get configured rules for validation
     *
     * @param $action
     * @return array
     * @throws \Exception
     */
    public function getRules($action = null) {
        $rules = $this->rules;

        if (is_array($rules) && $action && isset($rules[ $action ])) {
            $rules = $rules[ $action ];
        } else {
            throw new Exception('Validation rules for action "' . $action . '" was not denfied.', 500);
        }

        return $rules;

    }
}