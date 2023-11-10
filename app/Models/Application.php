<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $table = 'applications';

    public function user(){
        return $this->belongsTo(User::class,'FacultyID');
    }
    public function position(){
        return $this->belongsTo(Positions::class);
    }
}
