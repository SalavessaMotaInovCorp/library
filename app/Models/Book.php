<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    // Allow mass assignment for these fields
    protected $fillable = ['isbn', 'name', 'publisher_id', 'description', 'cover_image', 'price'];

    // Cast specific attributes to be encrypted
    protected function casts(): array {
        return [
            'isbn' => 'encrypted',
            'description' => 'encrypted',
            'cover_image' => 'encrypted',
            'price' => 'encrypted',
        ];
    }

    // Define relationship with publisher (many-to-one)
    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

    // Define many-to-many relationship with authors
    public function authors()
    {
        return $this->belongsToMany(Author::class);
    }

    public function bookRequests()
    {
        return $this->hasMany(BookRequest::class);
    }
}
