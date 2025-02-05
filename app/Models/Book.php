<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{

    use HasFactory;
    protected $fillable = ['isbn', 'name', 'publisher_id', 'description', 'cover_image', 'price'];

    protected function casts(): array {
        return [
            'isbn' => 'encrypted',
            'description' => 'encrypted',
            'cover_image' => 'encrypted',
            'price' => 'encrypted',
        ];
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

    public function authors()
    {
        return $this->belongsToMany(Author::class);
    }
}
