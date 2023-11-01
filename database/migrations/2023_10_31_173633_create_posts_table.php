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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete(); // if user account deleted, post/reply won't delete
            $table->foreignId('thread_id')->constrained()->cascadeOnDelete();
            $table->foreignId('parent_id')->nullable()->constrained(table: 'posts')->cascadeOnDelete()->cascadeOnDelete(); // nested relationship
            $table->mediumText('body');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
