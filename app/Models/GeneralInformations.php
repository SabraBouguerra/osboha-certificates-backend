<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralInformations extends Model
{
    use HasFactory;

    protected $fillable = [
        'reviews',
        'degree',
        'reviewer_id',
        'general_question',
        'summary',
        'user_books_id'
    ];

    public function user_books(){
        return $this->belongsTo(UserBook::class,'user_books_id');
    }
}
