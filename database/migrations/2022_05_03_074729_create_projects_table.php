<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->index()->nullable();
            $table->string('icon')->nullable();
            $table->string('group')->nullable();
            $table->string('title')->nullable();
            $table->string('url')->nullable();
            $table->text('description')->nullable();
            $table->string('repo')->nullable();
            $table->boolean('private')->default(false);
            $table->integer('sort_order')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
};
