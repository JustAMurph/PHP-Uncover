<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scans', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('application_id');
//            $table->foreign('application_id')->references('id')->on('applications');
            $table->text('entrypoints')->nullable();
            $table->text('settings')->nullable();
            $table->text('credentials')->nullable();
            $table->text('vulnerabilities')->nullable();
            $table->text('config')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scans');
    }
}
