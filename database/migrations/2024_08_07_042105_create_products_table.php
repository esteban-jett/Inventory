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
        Schema::create('products', function (Blueprint $table) {
            $table->enum('seniorPWD_discountable', ['yes','no'])->default('no');
            $table->unsignedBigInteger('business_id')->default(1);
            $table->foreign('business_id')->references('business_id')->on('businesses')->onDelete('cascade');
            $table->id();
            $table->string('name');
            $table->string('brand');
            $table->decimal('price', 8, 2);
            $table->string('category');
            $table->integer('stock');
            $table->integer('sold')->default(0);
            $table->string('status');
            $table->date('expDate');
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
