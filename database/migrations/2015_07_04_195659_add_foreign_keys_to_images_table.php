<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeysToImagesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('images', function(Blueprint $table) {
            $table->foreign('albom_id', 'fk_images_1')->references('id')->on('alboms')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('images', function(Blueprint $table) {
            $table->dropForeign('fk_images_1');
        });
    }

}
