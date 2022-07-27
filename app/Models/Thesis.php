<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thesis extends Model
{
    use HasFactory;

    protected $table = 'thesis';

    protected $fillable = [
        'thesis_text',
        'pages',
        'user_books_id'
    ];

    public function user_books(){
        return $this->belongsTo(UserBook::class,'user_books_id');
    }
}
