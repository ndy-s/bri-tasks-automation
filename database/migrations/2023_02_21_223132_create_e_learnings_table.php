<?php

use App\Models\M202;
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
        Schema::create('e_learnings', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(M202::class)->nullOnDelete()->cascadeOnUpdate();
            $table->string('pn');
            $table->string('name');
            $table->string('posisi');
            $table->string('area');
            $table->string('work_unit')->nullable();
            $table->integer('grade');
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
        Schema::dropIfExists('e_learnings');
    }
};
