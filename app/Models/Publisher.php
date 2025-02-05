<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'logo'];

    protected function casts(): array {
        return [
            'logo' => 'encrypted'
        ];
    }

    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
