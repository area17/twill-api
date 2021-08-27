<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsColumnsToBookTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('book_translations', function (Blueprint $table) {
            $table->string('subtitle', 100)->nullable();
            $table->text('summary')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('book_translations', function (Blueprint $table) {
            $table->dropColumn('subtitle');
            $table->dropColumn('summary');
        });
    }
}
