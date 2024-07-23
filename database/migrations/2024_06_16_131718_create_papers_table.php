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
        Schema::create('papers', function (Blueprint $table) {
            $table->id();
            $table->text('abstract')->nullable();
            $table->text('keyword')->nullable();
            $table->text('bibliography')->nullable();
            $table->string('file')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->boolean('is_published')->nullable();
            $table->boolean('published_review')->nullable();
            $table->timestamp('acc_at')->nullable();
            $table->timestamps();
            $table->foreignId('abstrak_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('papers');
    }
};
