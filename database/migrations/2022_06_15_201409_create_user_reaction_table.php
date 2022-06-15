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
        Schema::create('user_reaction', function (Blueprint $table) {
            $table->id();

//            $table->string('user_id');
            $table->foreignId('user_id')
                ->references('id')
                ->on('users')->onDelete('cascade');
//            $table->string('article_id');
            $table->foreignId('article_id')
                ->references('id')
                ->on('articles')->onDelete('cascade');

            $table->boolean('like')->default(false);
            $table->boolean('dislike')->default(false);

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_reaction');
    }
};
