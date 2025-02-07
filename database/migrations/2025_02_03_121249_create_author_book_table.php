<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Create the pivot table for many-to-many relationship between authors and books
        Schema::create('author_book', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('book_id')->constrained()->onDelete('cascade'); // Foreign key to books table
            $table->foreignId('author_id')->constrained()->onDelete('cascade'); // Foreign key to authors table
            $table->timestamps(); // Created_at and updated_at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the 'author_book' pivot table if it exists
        Schema::dropIfExists('author_book');
    }
};
