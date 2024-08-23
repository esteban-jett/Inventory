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
        Schema::create('website_page', function (Blueprint $table) {
            $table->increments('website_ID');
            // $table->unsignedBigInteger('business_id');
            // $table->unsignedBigInteger('product_id');
            // $table->foreign('business_id')->references('business_id')->on('business')->onDelete('cascade');
            // $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreignId('business_id')->references('business_id')->on('business')->onDelete('cascade');
            $table->foreignId('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->string('website_description');
            $table->string('website_image');
            $table->string('about_us');
            $table->timestamps();
    
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('website_page');
    }
};
