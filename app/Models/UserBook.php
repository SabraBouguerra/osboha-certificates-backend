<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBook extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function book(){
        return $this->belongsTo(Book::class,'book_id');
    }

    public function certificates(){
        return $this->hasMany(certificates::class);
    }
}
