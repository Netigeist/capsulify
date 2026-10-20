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
        Schema::create('notes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('category_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('title', 255);
            $table->text('content');

            $table->foreignId('file_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->date('due_date')->nullable();
            $table->boolean('is_completed')->default(false);

            $table->timestamps();

            $table->index('user_id');
            $table->index('category_id');
            $table->index('file_id');
            $table->index('due_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};
