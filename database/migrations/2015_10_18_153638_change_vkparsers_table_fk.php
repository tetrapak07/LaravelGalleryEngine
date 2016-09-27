<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeVkparsersTableFk extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('vkparsers', function(Blueprint $table) {
            $table->dropForeign('fk_vkparsers_1');
            $table->foreign('albom_id', 'fk_vkparsers_1')->references('id')->on('alboms')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('vkparsers', function(Blueprint $table) {
            $table->dropForeign('fk_vkparsers_1');
            $table->foreign('albom_id', 'fk_vkparsers_1')->references('id')->on('alboms')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

}
