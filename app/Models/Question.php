<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'reviews',
        'degree',
        'reviewer_id',
        'question',
        'pages',
        'quotation',
        'user_books_id'
    ];


    public function user_books(){
        return $this->belongsTo(UserBook::class,'user_books_id');
    }
}
