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
        // Create the 'books' table
        Schema::create('books', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('isbn')->unique(); // Unique ISBN for the book
            $table->text('name'); // Book name
            $table->foreignId('publisher_id')->constrained()->onDelete('cascade'); // Foreign key to publishers table
            $table->text('description')->nullable(); // Book description (optional)
            $table->text('cover_image')->nullable(); // Cover image URL (optional)
            $table->string('price'); // Book price
            $table->timestamps(); // Created_at and updated_at timestamps

            $table->fullText('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the 'books' table if it exists
        Schema::dropIfExists('books');
    }
};
