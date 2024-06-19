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
        Schema::create('revisi_abstraks', function (Blueprint $table) {
            $table->id();
            $table->text('note');
            $table->string('file')->nullable();
            $table->string('file_abstrak')->nullable();
            $table->timestamps();
            $table->foreignId('abstrak_id')->constrained();
            $table->foreignId('user_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('revisi_abstraks');
    }
};
