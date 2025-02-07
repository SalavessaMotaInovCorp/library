<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    // Allow mass assignment for these fields
    protected $fillable = ['name', 'photo'];

    // Cast the photo attribute to be encrypted
    protected function casts(): array {
        return [
            'photo' => 'encrypted'
        ];
    }

    // Define many-to-many relationship with books
    public function books()
    {
        return $this->belongsToMany(Book::class);
    }
}
