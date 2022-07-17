<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class general_informations extends Model
{
    use HasFactory;

    protected $fillable = [
        'general_question',
        'summary',
        'user_book_id'
    ];

    public function user_book(){
        return $this->belongsTo(UserBook::class,'user_book_id');
    }
}
