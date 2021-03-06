<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeAlbomsCategoriesTableFk extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('alboms_categories', function(Blueprint $table) {
            $table->dropForeign('fk_alboms_categories_1');
            $table->foreign('albom_id', 'fk_alboms_categories_1')->references('id')->on('alboms')->onUpdate('cascade')->onDelete('cascade');
            $table->dropForeign('fk_alboms_categories_2');
            $table->foreign('category_id', 'fk_alboms_categories_2')->references('id')->on('categories')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('alboms_categories', function(Blueprint $table) {
            $table->dropForeign('fk_alboms_categories_1');
            $table->foreign('albom_id', 'fk_alboms_categories_1')->references('id')->on('alboms')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->dropForeign('fk_alboms_categories_2');
            $table->foreign('category_id', 'fk_alboms_categories_2')->references('id')->on('categories')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

}
