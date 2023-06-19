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
        Schema::create('trucks', function (Blueprint $table) {
            $table->id();
            $table->string('unit', 255)->unique();
            $table->integer('year', false, 1);
            $table->string('notes', 255)->nullable();
            $table->timestamps();
        });
        // make the unit name as the key, keep the id, make subunits relationship to truck name 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trucks');
    }
};
