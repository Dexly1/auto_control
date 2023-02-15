<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('records', function (Blueprint $table) {
            $table->id();
            $table->integer('auto_id')->nullable();
            $table->longtext('img_out')->nullable(); //картинка при выезде
            $table->integer('edit_img_out')->nullable();
            $table->datetime('auto_time_out')->nullable();
            $table->longtext('img_in')->nullable(); //картинка при приезде
            $table->integer('edit_img_in')->nullable();
            $table->datetime('auto_time_in')->nullable();
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
        Schema::dropIfExists('records');
    }
};
