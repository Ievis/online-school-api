<?php

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class TeacherDescriptionFilter extends ModelFilter
{
    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relationMethod => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = [];
    protected $camel_cased_methods = false;

    public function user($user)
    {
        return $this->where('id', $user);
    }

    public function setup()
    {
        //
    }
}
