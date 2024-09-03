<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProductIdToOrdersTable extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Add product_id column
            $table->unsignedBigInteger('product_id')->after('order_id');

            // Add foreign key constraint
            $table->foreign('product_id')->references('pid')->on('products')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Drop foreign key constraint
            $table->dropForeign(['product_id']);

            // Drop product_id column
            $table->dropColumn('product_id');
        });
    }
}
