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
        Schema::create('abstraks', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('file')->nullable();
            $table->string('type_paper')->nullable();
            $table->text('abstract')->nullable();
            $table->text('keyword')->nullable();
            $table->boolean('originality')->default(0);
            $table->tinyInteger('status')->nullable();
            $table->timestamp('acc_at')->nullable();
            $table->timestamps();
            $table->foreignId('registration_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('abstraks');
    }
};
