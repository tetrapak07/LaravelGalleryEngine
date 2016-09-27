<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlbomsTable extends Migration {

    public function up() {
        Schema::create('alboms', function(Blueprint $table) {
            $table->bigInteger('id', true)->unsigned();
            $table->string('title');
            $table->string('slug');
            $table->string('description')->default('');
            $table->text('content')->default('');
            $table->string('keywords')->default('');
            $table->string('thumb', 1024)->default('');
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
        Schema::drop('alboms');
    }

}
