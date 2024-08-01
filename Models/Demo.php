<?php
namespace Models\User;
use Illuminate\Database\Eloquent\Model;

class Demo extends Model {
    protected $table = 'demo';
    protected $primaryKey = 'id';
    protected $hidden = [''];
    public $timestamps = false;
}
