<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class certificates extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_books_id'
    ];

    public function user_book(){
        return $this->belongsTo(UserBook::class,'user_books_id');
    }
}
