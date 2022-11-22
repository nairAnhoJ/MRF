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
        Schema::create('mrf', function (Blueprint $table) {
            $table->id();
            $table->string('area');
            $table->string('customer_name');
            $table->text('customer_address');
            $table->string('fleet_no');
            $table->string('brand_id');
            $table->string('model_id');
            $table->string('serial_no');
            $table->string('fsrr_no');
            $table->string('delivery_type');
            $table->text('remarks')->nullable();
            $table->string('supervisor_id');
            $table->string('parts')->nullable();
            $table->string('service')->nullable();
            $table->string('rental')->nullable();
            $table->string('mri')->nullable();
            $table->string('edoc')->nullable();
            $table->string('dr')->nullable();
            $table->string('requester');
            $table->string('request_for');
            $table->string('order_type');
            $table->string('mri_no')->nullable();
            $table->string('edoc_no')->nullable();
            $table->string('dr_no')->nullable();
            $table->date('date_needed');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mrf');
    }
};
