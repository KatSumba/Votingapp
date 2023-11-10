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
        Schema::create('applications', function (Blueprint $table) {
            $table->id('ApplicationID'); // Unique identifier for the application
            $table->string('FacultyID')->unique(); // Foreign key to FacultyID and unique
            $table->text('Manifesto'); // Text field for the application manifesto
            $table->string('Position'); // Position for which the application is submitted
            $table->string('Slogan'); // Slogan associated with the application
            $table->string('ApplicationStatus')->default('pending'); // Default value is 'pending'
            $table->timestamps(); // Created_at and updated_at timestamps

            // Define a foreign key constraint
            $table->foreign('FacultyID')->references('FacultyID')->on('users');
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
