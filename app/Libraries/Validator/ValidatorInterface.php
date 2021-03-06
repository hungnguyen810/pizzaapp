<?php namespace App\Libraries\Validator;

use Illuminate\Validation\ValidationException;

interface ValidatorInterface
{

    /**
     * Add data to validation against
     *
     * @param array
     * @return ValidatorInterface
     */
    public function with(array $input);

    /**
     * Pass the data and the rules to the validator
     *
     * @param string $action
     * @return boolean
     */
    public function passes($action = null);

    /**
     * Pass the data and the rules to the validator or throws ValidatorException
     *
     * @throws ValidationException
     * @param string $action
     * @return boolean
     */
    public function passesOrFail($action = null);

    /**
     * Retrive validation errors array
     *
     * @return array
     */
    public function errors();

    /**
     * Retrive validation errors bag
     *
     * @return array
     */
    public function errorsBag();

    /**
     * Set Rules for Validation
     *
     * @param array $rules
     * @return $this
     */
    public function setRules(array $rules);

    /**
     * Get rule for validation
     *
     * @param $action
     * @return array
     */
    public function getRules($action = null);
}