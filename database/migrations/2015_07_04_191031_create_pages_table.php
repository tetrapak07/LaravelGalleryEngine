<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('pages', function(Blueprint $table) {
            $table->bigInteger('id', true)->unsigned();
            $table->bigInteger('category_id')->unsigned()->nullable()->index('fk_pages_1_idx');
            $table->integer('page_number');
            $table->string('title');
            $table->string('description')->default('');
            $table->text('content')->default('');
            $table->string('keywords')->default('');
            $table->boolean('visible')->default(1);
            $table->string('rem')->default('');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('pages');
    }

}
