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
        // Create the 'publishers' table
        Schema::create('publishers', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('name'); // Publisher name
            $table->text('logo')->nullable(); // Logo (optional)
            $table->timestamps(); // Created_at and updated_at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the 'publishers' table if it exists
        Schema::dropIfExists('publishers');
    }
};
