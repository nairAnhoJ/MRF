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
        Schema::create('mrf_chargeable_requests', function (Blueprint $table) {
            $table->id();
            $table->string('number', 30);

            $table->string('site', 50);
            $table->string('area', 20);

            $table->string('customer_name');
            $table->string('customer_address');
            $table->string('customer_area', 20);

            $table->string('fsrr_number',30);
            $table->string('fsrr_path');
            $table->string('fsrr_date_received', 30);
            
            $table->string('brand', 20);
            $table->string('model', 30);
            $table->string('serial_number', 30);
            $table->string('fleet_number', 30);
            
            $table->string('hm', 30);
            $table->string('technician', 30);
            $table->string('working_environment', 5);
            $table->string('status', 5);
            $table->string('disc', 30);

            $table->string('delivery_type', 30);
            $table->date('date_needed', 15);
            
            // $table->string('attachments');
            $table->string('attachments', 50)->nullable();

            $table->string('service_coordinator_id', 10);
            $table->string('service_coordinator_name', 100);

            $table->date('date_requested', 15);
            $table->string('requestor', 100);
            $table->text('requestor_remarks')->nullable();

            $table->boolean('is_validated')->default(0);
            $table->string('validator', 100)->nullable();
            $table->string('datetime_validated', 25)->nullable();

            $table->boolean('is_verified')->default(0);
            $table->string('verifier', 100)->nullable();
            $table->string('datetime_verified', 25)->nullable();
            $table->text('verifier_remarks')->nullable();

            $table->boolean('is_service_head_approved1')->default(0);
            $table->string('service_head_approver1', 100)->nullable();
            $table->string('datetime_service_head_approved1', 25)->nullable();
            $table->text('service_head_remarks1')->nullable();

            $table->string('is_sq_number_encoded')->default(0);
            $table->string('sq_number', 50)->nullable();
            $table->string('sq_attachment', 100)->nullable();
            $table->string('sq_encoder', 100)->nullable();
            $table->string('datetime_sq_encoded', 25)->nullable();
            $table->text('sq_remarks')->nullable();

            $table->boolean('is_adviser_approved')->default(0);
            $table->string('adviser_approver', 100)->nullable();
            $table->string('datetime_adviser_approved', 25)->nullable();
            $table->text('adviser_remarks')->nullable();

            $table->boolean('is_service_coordinator_approved')->default(0);
            $table->string('matrix_attachment', 100)->nullable();
            $table->string('po_attachment', 100)->nullable();
            $table->string('service_coordinator_approver', 100)->nullable();
            $table->string('datetime_service_coordinator_approved', 25)->nullable();
            $table->text('service_coordinator_remarks')->nullable();

            $table->boolean('is_service_head_approved2')->default(0);
            $table->string('service_head_approver2', 100)->nullable();
            $table->string('datetime_service_head_approved2', 25)->nullable();
            $table->text('service_head_remarks2')->nullable();

            $table->boolean('is_mri_number_encoded')->default(0);
            $table->string('mri_number', 50)->nullable();
            $table->boolean('is_importation')->nullable();
            $table->string('mri_encoder', 100)->nullable();
            $table->string('datetime_mri_encoded', 25)->nullable();
            $table->text('mri_remarks')->nullable();

            $table->boolean('is_edoc_number_encoded')->default(0);
            $table->string('edoc_number', 50)->nullable();
            $table->text('serial_numbers')->nullable();
            $table->string('edoc_encoder', 100)->nullable();
            $table->string('datetime_edoc_encoded', 25)->nullable();
            $table->text('edoc_remarks')->nullable();

            $table->boolean('is_invoice_encoded')->default(0);
            $table->string('dr_number', 50)->nullable();
            $table->string('si_number', 50)->nullable();
            $table->string('bs_number', 50)->nullable();
            $table->string('invoice_encoder', 100)->nullable();
            $table->string('datetime_invoice_encoded', 25)->nullable();
            $table->text('invoice_remarks')->nullable();

            $table->boolean('is_confirmed')->default(0);
            $table->string('signatory', 100)->nullable();
            $table->string('datetime_confirmed', 25)->nullable();
            $table->text('signatory_remarks')->nullable();

            $table->boolean('is_returned')->default(0);
            $table->boolean('is_returned_by_parts')->default(0);
            $table->string('returned_by', 100)->nullable();
            $table->string('datetime_returned', 25)->nullable();
            $table->text('returned_remarks')->nullable();
            $table->string('returned_count', 3)->default(0);

            $table->boolean('is_cancelled')->default(0);
            $table->string('cancelled_by', 100)->nullable();
            $table->string('datetime_cancelled', 25)->nullable();
            $table->text('cancelled_remarks')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mrf_chargeable_requests');
    }
};
