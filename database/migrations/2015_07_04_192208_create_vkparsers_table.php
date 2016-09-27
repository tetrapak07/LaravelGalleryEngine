<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVkparsersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('vkparsers', function(Blueprint $table) {
            $table->integer('id');
            $table->integer('source1_id')->default(0);
            $table->integer('source2_id')->default(0);
            $table->integer('vk_albom_id')->default(0);
            $table->integer('max_count')->default(200);
            $table->integer('offset_count')->default(0);
            $table->bigInteger('albom_id')->unsigned()->nullable()->index('fk_vkparsers_1_idx');
            $table->integer('width')->default(320);
            $table->text('rem');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('vkparsers');
    }

}
