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
        Schema::create('categories', function (Blueprint $table) {
            $table->id('cid'); // Primary key
            $table->unsignedBigInteger('parent_id')->nullable(); // Nullable foreign key
            $table->foreign('parent_id')->references('cid')->on('categories')->onDelete('cascade'); // Foreign key constraint
            $table->string('category_name');
            $table->text('category_desc')->nullable();
            $table->timestamps(); // Timestamps for created_at and updated_at
        });
        Schema::table('products', function (Blueprint $table) {
            $table->foreign('cid')->references('cid')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      
        Schema::dropIfExists('categories');
    }
};
