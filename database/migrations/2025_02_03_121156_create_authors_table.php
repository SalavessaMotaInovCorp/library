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
        // Create the 'authors' table
        Schema::create('authors', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('name'); // Author's name
            $table->text('photo')->nullable(); // Author's photo (optional)
            $table->timestamps(); // Created_at and updated_at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the 'authors' table if it exists
        Schema::dropIfExists('authors');
    }
};
