<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blood_sugars', function (Blueprint $table) {
            $table->id();
            // I(mp) foreign key to user, cascade delete
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->decimal('value', 8, 2)->comment('mmol/L');
            $table->timestamp('recorded_at')->comment('Actual measurement datetime');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'recorded_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blood_sugars');
    }
};
