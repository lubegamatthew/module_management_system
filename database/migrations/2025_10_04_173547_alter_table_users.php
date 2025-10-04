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
        //
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('student')->after('email');
            $table->string('course')->nullable()->after('role');
            $table->string('gender')->nullable()->after('course');
            $table->string('profile_picture')->nullable()->after('gender');
            $table->string('phone')->nullable()->after('profile_picture');
            $table->string('status')->default('active')->after('profile_picture');
            $table->integer('login_status')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
