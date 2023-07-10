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
        Schema::create('boards', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->index()->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('sort_items_by')
                ->nullable()
                ->default(\App\Models\Board::SORT_ITEMS_BY_POPULAR);

            $table->boolean('can_users_create')->default(false);
            $table->boolean('block_comments')->default(false);
            $table->boolean('block_votes')->default(false);
            $table->boolean('visible')->default(true);
            $table->foreignId('project_id')->nullable()->constrained();
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
        Schema::dropIfExists('boards');
    }
};
