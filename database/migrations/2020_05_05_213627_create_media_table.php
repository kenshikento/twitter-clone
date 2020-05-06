<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media', function (Blueprint $table) {
            $table->bigInteger('id')->unsigned()->primary();
            $table->string('id_str')->unique();

            $table->text('display_url');
            $table->text('indices');
            $table->text('media_url');
            $table->text('media_url_https');
            $table->text('expanded_url');
            $table->text('sizes');
            $table->text('url');
            $table->text('type');    

            $table->unsignedBigInteger('entity_id');
            $table->foreign('entity_id')->references('id')->on('entity');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('media');
    }
}
