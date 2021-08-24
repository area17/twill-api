<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAuthorsTables extends Migration
{
    public function up()
    {
        Schema::create('authors', function (Blueprint $table) {
            createDefaultTableFields($table);

            $table->string('title', 200)->nullable();

            $table->text('biography')->nullable();

            $table->integer('position')->unsigned()->nullable();

            $table->json('content')->nullable();
        });

        Schema::create('author_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'author');
        });
    }

    public function down()
    {
        Schema::dropIfExists('author_slugs');
        Schema::dropIfExists('authors');
    }
}
