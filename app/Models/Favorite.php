<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Favorite extends Model
{
    use HasFactory;
    public $timestamps = false;
    ##### Collaborative Project
    public function post(){
        return $this->belongsTo(post::class);
    }
}