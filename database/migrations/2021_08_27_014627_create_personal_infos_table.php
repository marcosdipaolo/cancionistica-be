<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonalInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personal_infos', function (Blueprint $table) {
            $table->uuid("id");
            $table->string("first_name");
            $table->string("last_name");
            $table->string("phonenumber");
            $table->string("address_line_1");
            $table->string("address_line_2");
            $table->string("postcode");
            $table->string("city");
            $table->string("country");
            $table->foreignUuid("user_id");
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
        Schema::dropIfExists('personal_infos');
    }
}
