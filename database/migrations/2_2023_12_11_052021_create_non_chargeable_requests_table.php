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
        Schema::create('mrf_non_chargeable_requests', function (Blueprint $table) {
            $table->id();
            $table->string('number')->nullable();
            $table->string('site');
            $table->string('area');
            $table->string('customer_name');
            $table->string('customer_address');
            $table->string('customer_area');
            $table->string('for'); // PM or REPAIR
            $table->string('order_type'); // IN-STOCK or REQUEST PARTS
            $table->string('fleet_number');
            $table->string('brand');
            $table->string('model');
            $table->string('serial_number');
            $table->string('fsrr_number');
            $table->string('fsrr_path');
            $table->string('delivery_type'); // REGULAR , SAME DAY , PICK UP , AIR , SEA , OTHERS

            $table->date('date_requested');
            $table->string('requestor');
            $table->binary('requestor_remarks')->nullable();

            $table->boolean('is_validated')->default(0);
            $table->string('validator')->nullable();
            $table->string('datetime_validated')->nullable();
            $table->binary('validator_remarks')->nullable();

            $table->boolean('is_verified')->default(0);
            $table->string('verifier')->nullable();
            $table->string('datetime_verified')->nullable();
            $table->binary('verifier_remarks')->nullable();

            $table->boolean('is_service_approved')->default(0);
            $table->string('service_approver')->nullable();
            $table->string('datetime_service_approved')->nullable();
            $table->binary('service_remarks')->nullable();

            // $table->boolean('is_rental_approved')->default(0);
            // $table->string('rental_approver')->nullable();
            // $table->string('datetime_rental_approved')->nullable();
            // $table->binary('rental_remarks')->nullable();

            $table->string('is_mri_number_encoded')->default(0);
            $table->string('mri_number')->nullable();
            $table->string('mri_encoder')->nullable();
            $table->string('datetime_mri_encoded')->nullable();
            $table->binary('mri_remarks')->nullable();

            $table->string('is_edoc_number_encoded')->default(0);
            $table->string('edoc_number')->nullable();
            $table->string('serial_numbers')->nullable();
            $table->string('edoc_encoder')->nullable();
            $table->string('datetime_edoc_encoded')->nullable();
            $table->binary('edoc_remarks')->nullable();

            $table->string('is_dr_number_encoded')->default(0);
            $table->string('dr_number')->nullable();
            $table->string('dr_encoder')->nullable();
            $table->string('datetime_dr_encoded')->nullable();
            $table->binary('dr_remarks')->nullable();

            $table->boolean('is_confirmed')->default(0);
            $table->string('signatory')->nullable();
            $table->string('datetime_confirmed')->nullable();
            $table->binary('signatory_remarks')->nullable();

            $table->string('is_returned')->default(0);
            $table->string('is_returned_by_parts')->default(0);
            $table->string('returned_by')->nullable();
            $table->string('datetime_returned')->nullable();
            $table->binary('returned_remarks')->nullable();
            $table->string('returned_count')->default(0);

            $table->date('date_needed');

            $table->boolean('is_cancelled')->default(0);
            $table->string('cancelled_by')->nullable();
            $table->string('datetime_cancelled')->nullable();
            $table->binary('cancelled_remarks')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mrf_non_chargeable_requests');
    }
};
