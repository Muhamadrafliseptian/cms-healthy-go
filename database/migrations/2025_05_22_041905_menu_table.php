<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lpt_batch_menu', function (Blueprint $table) {
            $table->id();
            $table->foreignId('batch_id')->constrained('lptm_batch')->onDelete('cascade');
            $table->string('day')->nullable();
            $table->string('img_menu')->nullable();
            $table->string('dinner_menu')->nullable();
            $table->string('lunch_menu')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lpt_batch_menu');
    }
};
