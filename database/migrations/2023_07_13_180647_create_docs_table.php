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
        Schema::create('docs', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->index();
            $table->string('title');
            $table->string('icon')->nullable();
            $table->text('description')->nullable();
            $table->enum('visibility', ['private', 'unlisted', 'public'])->default('public');
            $table->integer('order')->default(0)->index();
            $table->foreignId('project_id')->nullable()->constrained();
            $table->foreignId('user_id')->nullable()->constrained();
            $table->timestamps();
        });

        Schema::create('doc_versions', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->index();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('visibility', ['private', 'unlisted', 'public'])->default('public');
            $table->foreignId('doc_id')->constrained();
            $table->foreignId('project_id')->nullable()->constrained();
            $table->foreignId('user_id')->nullable()->constrained();
            $table->timestamps();
        });

        Schema::create('doc_pages', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->index();
            $table->string('title');
            $table->longText('content')->nullable();
            $table->string('icon')->nullable();
            $table->string('content_type')->default('html');
            $table->enum('visibility', ['private', 'unlisted', 'public'])->default('public');
            $table->integer('order')->default(0)->index();
            $table->foreignId('doc_id')->constrained();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('version_id');
            $table->foreignId('project_id')->nullable()->constrained();
            $table->foreignId('user_id')->nullable()->constrained();
            $table->boolean('is_draft')->default(0);
            $table->timestamps();

            $table->foreign('version_id')
                ->references('id')
                ->on('doc_versions')
                ->cascadeOnDelete();

            $table->foreign('parent_id')
                ->references('id')
                ->on('doc_pages')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('docs');
        Schema::dropIfExists('doc_versions');
        Schema::dropIfExists('doc_pages');
    }
};
