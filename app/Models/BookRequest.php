<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookRequest extends Model
{
    protected $fillable = [
        'user_id',
        'book_id',
        'user_name',
        'user_email',
        'request_date',
        'due_date',
        'return_date',
        'is_returned',
        'is_confirmed',
        'confirmed_at',
        'total_request_days',
        'status',
    ];

    protected function casts(): array {
        return [
            'user_email' => 'encrypted',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

}
