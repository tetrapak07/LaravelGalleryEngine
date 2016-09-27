<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeysToVkparsersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('vkparsers', function(Blueprint $table) {
            $table->foreign('albom_id', 'fk_vkparsers_1')->references('id')->on('alboms')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('pages', function(Blueprint $table) {
            $table->dropForeign('fk_vkparsers_1');
        });
    }

}
