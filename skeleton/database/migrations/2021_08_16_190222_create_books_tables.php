<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBooksTables extends Migration
{
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            createDefaultTableFields($table);
        });

        Schema::create('book_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'book');
        });

        Schema::create('book_revisions', function (Blueprint $table) {
            createDefaultRevisionsTableFields($table, 'book');
        });

        Schema::create('book_translations', function (Blueprint $table) {
            createDefaultTranslationsTableFields($table, 'book');
            $table->string('title', 200)->nullable();
            $table->text('description')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('book_translations');
        Schema::dropIfExists('book_revisions');
        Schema::dropIfExists('book_slugs');
        Schema::dropIfExists('books');
    }
}
