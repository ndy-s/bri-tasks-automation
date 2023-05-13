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
        Schema::create('m202_s', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name');
            $table->string('type');
            $table->string('duration');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->string('facilitator');
            $table->string('maker');
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
        Schema::dropIfExists('m202_s');
    }
};
