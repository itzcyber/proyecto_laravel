<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;


    protected $fillable = ['title', 'slug', 'category_id', 'posted', 'content', 'description', 'image'];

    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}
