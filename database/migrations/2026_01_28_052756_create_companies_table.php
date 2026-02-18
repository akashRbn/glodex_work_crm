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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id');
            $table->foreignId('lawyer_id')->comment('references the lawyer responsible for the company');
            $table->string('company_name', 255);
            $table->string('company_city', 150);
            $table->string('company_email', 255);
            $table->string('company_phone', 20);  
            $table->string('website_link');
            $table->text('address');
            $table->longText('logo');
            $table->longText('description');
            $table->tinyInteger('status')->default(1)->comment('1 = Active, 0 = Inactive');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
