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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('post_type_id');
            $table->unsignedBigInteger('admin_id');
            $table->string('title');
            $table->string('thumbnail');
            $table->longText('content');
            $table->integer('view')->default(0);
            $table->timestamps();

            $table->foreign('post_type_id')->references('id')->on('post_types')->onDelete('cascade');
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
 /*php*/
