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
        Schema::create('mrf_chargeable_request_parts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('request_id');
            $table->bigInteger('part_id');
            $table->string('part_number', 30);
            $table->string('part_name', 100);
            $table->string('brand', 20);
            $table->string('quantity', 10);
            $table->string('price', 15);
            $table->string('total_price', 15);
            $table->boolean('with_error')->default(0);
            $table->string('edoc_number', 50)->default(0);
            $table->string('dr_number', 50)->default(0);
            $table->string('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mrf_chargeable_request_parts');
    }
};
