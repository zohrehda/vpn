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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->nullable();
            $table->string('email')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('role')->nullable();
            $table->string('password')->nullable();
            $table->string('referral_id')->nullable();
            $table->string('referral_code')->nullable();
            $table->integer('referrals')->default(0);
            $table->integer('fix_discount')->default(0);
            $table->integer('rank')->default(0);
            $table->string('server_username')->nullable();
            $table->string('server_password')->nullable();
            $table->timestamp('last_seen')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
