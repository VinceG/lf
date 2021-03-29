<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TableSchema extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->uuid('post_id')->default(null)->nullable()->index();
            $table->string('url');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('posts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title')->default(null)->nullable()->index();
            $table->text('body')->default(null)->nullable();
            $table->unsignedBigInteger('main_image')->default(null)->nullable();
            $table->unsignedBigInteger('owner_id')->default(null)->nullable()->index();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('main_image')->references('id')->on('files')->onDelete('CASCADE');
            $table->foreign('owner_id')->references('id')->on('users')->onDelete('CASCADE');
        });

        Schema::table('files', function (Blueprint $table) {
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('CASCADE');
        });

        Schema::create('tag_post_relation', function (Blueprint $table) {
            $table->uuid('post_id')->nullable(false);
            $table->unsignedBigInteger('tag_id');

            $table->unique(['post_id', 'tag_id']);

            $table->foreign('post_id')->references('id')->on('posts')->onDelete('CASCADE');
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('files');
        Schema::dropIfExists('tag_post_relation');
        Schema::dropIfExists('posts');
        Schema::dropIfExists('tags');
    }
}
