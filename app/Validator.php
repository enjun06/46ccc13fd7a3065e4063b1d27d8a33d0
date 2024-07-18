<?php

namespace App;

use Illuminate\Validation\Factory;
use Illuminate\Translation\Translator;
use Illuminate\Translation\ArrayLoader;

class Validator
{
    protected $factory;

    public function __construct()
    {
        $this->factory = new Factory(new Translator(new ArrayLoader(), 'en'));
    }

    public function validate($data, $rules)
    {
        $validator = $this->factory->make($data, $rules);

        if ($validator->fails()) {
            return $validator->errors();
        }

        return true;
    }
}
