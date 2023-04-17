<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdColumnToRelatedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $related = config('twill.related_table', 'twill_related');

        if (! Schema::hasColumn($related, 'id')) {
            Schema::table($related, function (Blueprint $table) {
                $table->increments('id')->first();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // let's keep the column for Twill 3.x compatibility
    }
}
