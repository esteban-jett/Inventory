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
        Schema::create('financial_report', function (Blueprint $table) {
            $table->increments('report_Id');
            $table->foreignId('business_Id')->references('business_Id')->on('business')->onDelete('cascade');
            $table->date('report_date');
            $table->string('total_sales');
            $table->string('net_profit');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_report');
    }
};
