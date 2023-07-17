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
        Schema::create('doc_chapters', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->indexed();
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('sort_order')->nullable();
            $table->foreignId('doc_id')->constrained();
            $table->foreignId('user_id')->nullable()->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doc_chapters');
    }
};
