<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'photo'];

    protected function casts(): array {
        return [
            'photo' => 'encrypted'
        ];
    }

    public function books()
    {
        return $this->belongsToMany(Book::class);
    }
}
