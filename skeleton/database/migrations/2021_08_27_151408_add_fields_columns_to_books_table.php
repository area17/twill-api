<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsColumnsToBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('books', function (Blueprint $table) {
            $table->string('isbn', 200);
            $table->date('publication_date')->nullable();
            $table->json('formats')->nullable();
            $table->json('topics')->nullable();
            $table->boolean('forthcoming')->default(false);
            $table->json('available')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn('isbn');
            $table->dropColumn('publication_date');
            $table->dropColumn('formats');
            $table->dropColumn('topics');
            $table->dropColumn('forthcoming');
            $table->dropColumn('available');
        });
    }
}
