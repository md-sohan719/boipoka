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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->string('author');
            $table->string('isbn')->nullable();
            $table->decimal('price', 10, 2);
            $table->enum('condition', ['new', 'like_new', 'very_good', 'good', 'acceptable']);
            $table->enum('listing_type', ['sell', 'exchange', 'both'])->default('sell');
            $table->string('category')->nullable();
            $table->integer('publication_year')->nullable();
            $table->string('language')->default('english');
            $table->string('image')->nullable();
            $table->enum('status', ['available', 'sold', 'exchanged', 'reserved'])->default('available');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
