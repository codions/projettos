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
        Schema::create('doc_pages', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->indexed();
            $table->string('name');
            $table->longText('content')->nullable();
            $table->string('content_type')->default('html');
            $table->integer('sort_order')->nullable();
            $table->foreignId('doc_id')->constrained();
            $table->unsignedBigInteger('chapter_id');
            $table->foreignId('user_id')->nullable()->constrained();
            $table->boolean('is_draft')->default(0);
            $table->timestamps();

            $table->foreign('chapter_id')
                ->references('id')
                ->on('doc_chapters')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doc_pages');
    }
};
