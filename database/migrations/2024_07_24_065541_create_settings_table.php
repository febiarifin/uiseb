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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->text('information')->nullable();
            $table->string('template_abstract')->nullable();
            $table->string('template_full_paper')->nullable();
            $table->string('template_video')->nullable();
            $table->string('confirmation_letter')->nullable();
            $table->string('copyright_letter')->nullable();
            $table->string('self_declare_letter')->nullable();
            $table->string('flayer')->nullable();
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
        Schema::dropIfExists('settings');
    }
};
