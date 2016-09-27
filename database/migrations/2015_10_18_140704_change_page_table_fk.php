<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangePageTableFk extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('pages', function(Blueprint $table) {
            $table->dropForeign('fk_pages_1');
            $table->foreign('category_id', 'fk_pages_1')->references('id')->on('categories')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('pages', function(Blueprint $table) {
            $table->dropForeign('fk_pages_1');
            $table->foreign('category_id', 'fk_pages_1')->references('id')->on('categories')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

}
