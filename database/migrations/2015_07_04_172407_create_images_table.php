<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('images', function(Blueprint $table) {
            $table->bigInteger('id', true)->unsigned();
            $table->bigInteger('albom_id')->unsigned()->index('fk_images_1_idx');
            $table->string('title');
            $table->string('slug');
            $table->string('alt_text')->default('');
            $table->string('caption')->default('');
            $table->string('description')->default('');
            $table->text('notes', 65535)->default('');
            $table->text('content')->default('');
            $table->string('keywords')->default('');
            $table->string('ext', 16)->default('');
            $table->string('file_type', 32)->default('');
            $table->string('file_size', 32)->default('');
            $table->integer('width')->default(0);
            $table->integer('height')->default(0);
            $table->string('url', 1024)->default('');
            $table->string('url_thumb', 1024)->default('');
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
        Schema::drop('images');
    }

}
