<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
    use HasFactory;

    // Allow mass assignment for these fields
    protected $fillable = ['name', 'logo'];

    // Cast the logo attribute to be encrypted
    protected function casts(): array {
        return [
            'logo' => 'encrypted'
        ];
    }

    // Define one-to-many relationship with books
    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
