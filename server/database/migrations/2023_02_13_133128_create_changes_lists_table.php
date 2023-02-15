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
        Schema::create('changes_lists', function (Blueprint $table) {
            $table->id();
            $table->integer('auto_id')->nullable(); 
            $table->integer('record_id')->nullable(); 
            $table->integer('record_type')->nullable();
            $table->longtext('comment')->nullable();
            $table->longtext('img_old')->nullable();
            $table->longtext('img_new')->nullable();    
            $table->datetime('create_date')->nullable();
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
        Schema::dropIfExists('changes_lists');
    }
};
