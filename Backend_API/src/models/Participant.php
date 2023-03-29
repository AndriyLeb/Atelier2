<?php

namespace reunionou\models;

class Participant extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'participants';
    protected $primaryKey = 'id';
    public $keyType = 'int';
    public $timestamps = true;
}