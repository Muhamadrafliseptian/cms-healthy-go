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
        Schema::create('lpt_section_content', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_id')->constrained('lptm_section_category')->onDelete('cascade');
            $table->string('section')->nullable();
            $table->string('title')->nullable();
            $table->text('subtitle1')->nullable();
            $table->text('subtitle2')->nullable();
            $table->text('subtitle3')->nullable();
            $table->text('subtitle4')->nullable();
            $table->string('img')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lpt_section_content');
    }
};
