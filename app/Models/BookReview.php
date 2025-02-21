<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookReview extends Model
{
    // Allow mass assignment for these fields
    protected $fillable = [
        'book_id',
        'user_id',
        'rating',
        'comment',
        'status',
        'justification',
        'created_at',
        'updated_at'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

}
