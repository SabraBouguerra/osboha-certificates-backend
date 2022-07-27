<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class question extends Model
{
    use HasFactory;

    protected $fillable = [
        'question',
        'pages',
        'quotation',
        'user_books_id'
    ];


    public function user_books(){
        return $this->belongsTo(UserBook::class,'user_books_id');
    }
}
