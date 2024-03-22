<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'status', 'category_id', 'image', 'price'];

    protected $with = ['category'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getCategoryNameAttribute()
    {
        return $this->category->name;
    }

    public function getImageUrlAttribute()
    {
        if (!empty($this->image)) {
            return asset('storage/' . $this->image);
        }
        
        return null;
    }
}
