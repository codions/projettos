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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->index();
            $table->string('title')->nullable();
            $table->text('content')->nullable();
            $table->unsignedInteger('total_votes')->nullable()->default(0);
            $table->boolean('pinned')->default(false);
            $table->boolean('private')->default(false);
            $table->boolean('notify_subscribers')->default(true);
            $table->foreignId('project_id')->nullable()->constrained();
            $table->foreignId('board_id')->nullable()->constrained();
            $table->foreignId('user_id')->nullable()->constrained();
            $table->bigInteger('issue_number')->nullable();

            $table->timestamps();
        });

        Schema::create('item_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->nullable()->constrained();
            $table->foreignId('user_id')->nullable()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
};
