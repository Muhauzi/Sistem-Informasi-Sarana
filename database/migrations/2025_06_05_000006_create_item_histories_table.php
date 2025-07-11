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
        Schema::create('item_histories', function (Blueprint $table) {
            $table->id();
            $table->string('item_id');
            $table->foreign('item_id')->references('id')->on('items')->cascadeOnDelete();
            $table->foreignId('from_division_id')->nullable()->constrained('divisions')->nullOnDelete();
            $table->foreignId('to_division_id')->constrained('divisions')->cascadeOnDelete();
            $table->uuid('moved_by');
            $table->foreign('moved_by')->references('id')->on('users')->cascadeOnDelete();
            $table->dateTime('moved_at');
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_histories');
    }
};
