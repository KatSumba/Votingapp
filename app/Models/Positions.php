<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Positions extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $table = 'positions';

    public function application()
    {
        return $this->hasMany(Application::class);
    }
    public function test()
    {
        return $this->hasMany(Application::class);
    }
    public function applications()
    {
        return $this->hasMany(Application::class, 'Position', 'name');
    }
}
