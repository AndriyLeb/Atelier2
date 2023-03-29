<?php

namespace reunionou\models;

class Event extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'events';
    protected $primaryKey = 'id';
    public $keyType = 'int';
    public $timestamps = true;
}