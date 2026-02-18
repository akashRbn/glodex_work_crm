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
        Schema::create('user_infos', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('poc');
            $table->string('website_url');
            $table->string('social_url');
            $table->string('whatsapp_no');
            $table->string('trade_license_number');
            $table->longText('trade_license_copy');
            $table->longText('passport_nid_copy');
            $table->longText('bank_account_name');
            $table->longText('bank_name');
            $table->longText('bank_account_number');
            $table->longText('bank_address');
            $table->string('swift_code');
            $table->string('ifsc_code')->nullable();
            $table->string('branch_name')->nullable();
            $table->string('benificiary_number')->nullable();
            $table->string('benificiary_address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_infos');
    }
};
