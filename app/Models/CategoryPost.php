<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryPost extends Model
{
    use HasFactory;

    protected $table = 'category_post';               //tell the model that the table to interact is category_post
    protected $fillable = ['category_id', 'post_id'];// the column fields of the category_post table
    public $timestamps = false;                      //set to false, we don't need to use created_at, updated_at

    # Use this method to get the name of the category
    public function category(){
        return $this->belongsTo(Category::class);
    }
}
