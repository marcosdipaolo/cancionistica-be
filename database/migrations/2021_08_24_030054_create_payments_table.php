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
            $table->uuid("id");
            $table->string("collection_id");
            $table->string("collection_status");
            $table->string("payment_id");
            $table->string("status");
            $table->string("payment_type");
            $table->string("merchant_order_id");
            $table->string("preference_id");
            $table->string("site_id");
            $table->string("processing_mode");
            $table->unique("preference_id");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
