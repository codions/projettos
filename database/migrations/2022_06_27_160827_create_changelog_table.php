<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('changelogs', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->index();
            $table->string('title')->nullable();
            $table->text('content')->nullable();
            $table->dateTime('published_at')->nullable();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('project_id')->nullable()->constrained();
            $table->timestamps();
        });
    }
};
