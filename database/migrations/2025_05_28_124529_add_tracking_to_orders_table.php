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
        Schema::table('orders', function (Blueprint $table) {
            // Summary
            $table->string('awb')->nullable()->index(); // Nomor resi
            $table->string('courier')->nullable();
            $table->string('service_code')->nullable();
            $table->string('status_summary')->nullable();

            // Details
            $table->string('waybill_number')->nullable();
            $table->date('waybill_date')->nullable();
            $table->time('waybill_time')->nullable();
            $table->string('weight')->nullable();
            $table->string('origin')->nullable();
            $table->string('destination')->nullable();

            $table->string('shipper_name')->nullable();
            $table->text('shipper_address1')->nullable();
            $table->text('shipper_address2')->nullable();
            $table->text('shipper_address3')->nullable();
            $table->string('shipper_city')->nullable();

            $table->string('receiver_name')->nullable();
            $table->text('receiver_address1')->nullable();
            $table->text('receiver_address2')->nullable();
            $table->text('receiver_address3')->nullable();
            $table->string('receiver_city')->nullable();

            // Delivery status
            $table->string('pod_receiver')->nullable();
            $table->date('pod_date')->nullable();
            $table->time('pod_time')->nullable();

            // JSON blob untuk manifest
            $table->json('manifest')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'awb',
                'courier',
                'service_code',
                'status',
                'waybill_number',
                'waybill_date',
                'waybill_time',
                'weight',
                'origin',
                'destination',
                'shipper_name',
                'shipper_address1',
                'shipper_address2',
                'shipper_address3',
                'shipper_city',
                'receiver_name',
                'receiver_address1',
                'receiver_address2',
                'receiver_address3',
                'receiver_city',
                'pod_receiver',
                'pod_date',
                'pod_time',
                'manifest'
            ]);
        });
    }
};
