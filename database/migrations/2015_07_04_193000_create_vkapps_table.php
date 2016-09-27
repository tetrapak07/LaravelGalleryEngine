<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVkappsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('vkapps', function(Blueprint $table) {
            $table->integer('id');
            $table->integer('app_id');
            $table->string('app_secret');
            $table->text('access_rights');
            $table->text('app_token')->default('');
            $table->text('rem')->default('');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('vkapps');
    }

}
