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
        Schema::create('mrf_rental_request_parts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('rental_request_id');
            $table->bigInteger('part_id');
            $table->string('part_number');
            $table->string('part_name');
            $table->string('brand');
            $table->string('quantity');
            $table->string('price');
            $table->string('total_price');
            $table->string('with_error')->default(0);
            $table->string('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mrf_rental_request_parts');
    }
};
