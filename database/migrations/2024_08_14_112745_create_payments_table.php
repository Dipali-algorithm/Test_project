<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id(); // id column (auto-incrementing primary key)
            $table->string('payment_id')->unique(); // payment_id column, should be unique
            $table->string('payment_status'); // payment_status column
            $table->decimal('total_payment', 10, 2); // total_payment column with precision and scale
            $table->unsignedBigInteger('order_id'); // Foreign key column
            $table->timestamps(); // created_at and updated_at columns

            // Foreign key constraint
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign(['order_id']); // Drop foreign key constraint
        });

        Schema::dropIfExists('payments');
    }
}
