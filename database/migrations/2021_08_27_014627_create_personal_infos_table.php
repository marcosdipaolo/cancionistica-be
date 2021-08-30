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
            $table->string("address_line_1")->nullable();
            $table->string("address_line_2")->nullable();
            $table->string("postcode")->nullable();
            $table->string("city")->nullable();
            $table->string("country")->nullable();
            $table->foreignUuid("user_id")->unique();
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
