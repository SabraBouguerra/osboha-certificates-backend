<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_name',
        'pages',
        'type_id',
        'category_id'
    ];

    public function users(){
        return $this->belongsToMany(User::class,'user_books');
    }


    protected $with = array('type','category');

    public function type(){
        return $this->belongsTo(BookType::class,'type_id');
    }

    public function category(){
        return $this->belongsTo(BookCategory::class,'category_id');
    }
}
