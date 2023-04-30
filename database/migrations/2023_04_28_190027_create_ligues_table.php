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
        Schema::create('ligues', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('ligue_id');
            $table->string('nom',250);
            $table->string('type',250);
            $table->string('logo',250);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ligues');
    }
};
