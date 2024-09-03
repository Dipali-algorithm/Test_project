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
        Schema::create('products', function (Blueprint $table) {
            $table->id('pid'); // Auto-incrementing ID (Primary key)
            $table->unsignedBigInteger('cid'); // Foreign key
            $table->string('product_name', 255); // String for product name with a max length of 255
            $table->text('product_desc'); // Text field for product description
            $table->decimal('product_price', 10, 2); // Decimal for price with precision 10 and scale 2
            $table->timestamps(); // Timestamps for created_at and updated_at
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
