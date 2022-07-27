<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class thesis extends Model
{
    use HasFactory;

    protected $fillable = [
        'thesis_text',
        'pages',
        'user_books_id'
    ];

    public function user_books(){
        return $this->belongsTo(UserBook::class,'user_books_id');
    }
}
