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
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->string('payment_image')->nullable();
            $table->string('paper')->nullable();
            $table->tinyInteger('is_valid')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->timestamp('validated_at')->nullable();
            $table->timestamp('acc_at')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
            $table->foreignId('category_id')->constrained();
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
        Schema::dropIfExists('registrations');
    }
};
