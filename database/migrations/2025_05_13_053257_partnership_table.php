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
        Schema::create('lpt_partnership', function(Blueprint $table){
            $table->id();
            $table->string('title_partnership')->nullable();
            $table->string('program_partnership')->nullable();
            $table->text('content_program_partnership')->nullable();
            $table->string('img_partnership')->nullable();
            $table->string('btn_color')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lpt_partnership');
    }
};
