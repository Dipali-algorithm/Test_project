<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenamePaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('payments', 'orders');
        Schema::table('orders', function (Blueprint $table) {
            $table->renameColumn('payment_status', 'order_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('payments', 'orders');
        Schema::table('orders', function (Blueprint $table) {
            $table->renameColumn('payment_status', 'order_status');
        });
    }
}
