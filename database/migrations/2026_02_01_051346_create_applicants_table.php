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
        Schema::create('applicants', function (Blueprint $table) {
            $table->id();
             $table->integer('user_id')->comment('applicant user id');
            $table->string('applicant_code');
            $table->string('name');
            $table->string('phone')->unique();
            $table->string('email')->unique();
            $table->date('dob')->nullable();
            $table->string('passport_no')->unique();
            $table->string('permanent_address');
            $table->string('fathers_name');
            $table->string('mothers_name');
            $table->integer('gender');
            $table->integer('moi')->nullable();
            $table->longText('notes')->nullable();
            $table->json('english_proficiency')->nullable();
            $table->json('academic_qualifications')->nullable();
            $table->string('sent_by')->nullable()->comment('which agent sent this student');
            $table->integer('created_by')->comment('who created this student');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicants');
    }
};
