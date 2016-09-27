<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlbomsCategoriesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('alboms_categories', function(Blueprint $table) {
            $table->bigInteger('albom_id')->unsigned()->index('fk_alboms_categories_1_idx');
            $table->bigInteger('category_id')->unsigned()->index('fk_alboms_categories_2_idx');
            $table->primary(['albom_id', 'category_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('alboms_categories');
    }

}
