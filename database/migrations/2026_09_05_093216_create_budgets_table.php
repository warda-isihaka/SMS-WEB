<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('budgets', function (Blueprint $table) {
            $table->id('budget_id'); // Primary key 
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Foreign key
            $table->integer('amount'); // Allocated amount
            $table->timestamps();
        }); // <-- HAPA NDIPO PALIPOPOKOSA: Mabano na semikoloni vilikosekana
    }

    public function down(): void
    {
        Schema::dropIfExists('budgets');
    }
};