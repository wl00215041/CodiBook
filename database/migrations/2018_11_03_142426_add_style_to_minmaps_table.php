<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStyleToMinmapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mind_maps', function (Blueprint $table) {
            $table->string('style')->after('mindmap')
                                   ->default('primary');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mind_maps', function (Blueprint $table) {
            $table->dropColumn('style');
        });
    }
}
