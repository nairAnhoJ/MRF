<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mrf_users', function (Blueprint $table) {
            $table->id();
            $table->string('id_number');
            $table->string('name');
            $table->string('password')->default(Hash::make('password2023'));
            $table->integer('role');
            $table->string('site');
            $table->string('area');
            $table->boolean('first_time_login')->default(1);
            $table->boolean('is_deleted')->default(0);
            $table->string('key');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mrf_users');
    }
};
