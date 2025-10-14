<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lesson', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('instructor_id');
            $table->string('name', 50);
            $table->string('image_path', 255)->nullable();
            $table->unsignedBigInteger('studio_id');
            $table->timestamp('start_time');
            $table->timestamp('end_time');
            $table->text('explanation')->nullable();
            $table->integer('max_user_num');
            $table->integer('booking_user_num');
            $table->unsignedBigInteger('lesson_category_id');
            $table->timestamps();

            $table->foreign('lesson_category_id')->references('id')->on('lesson_category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lesson');
    }
};
