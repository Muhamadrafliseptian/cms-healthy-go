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
        Schema::create('lpt_program', function(Blueprint $table){
            $table->id();
            $table->string('program_title')->nullable();
            $table->string('program_subtitle')->nullable();
            $table->string('program_subtitle_2')->nullable();
            $table->text('content_program')->nullable();
            $table->text('content_program_2')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lpt_program');
    }
};
