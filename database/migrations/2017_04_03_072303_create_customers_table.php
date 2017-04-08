<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
             $table->increments('id');
            $table->string('name',100);
            $table->integer('gender')->default(1)->comment('1: Nam, 0: nữ');
            $table->integer('age')->nullable();
            $table->mediumText('address')->nullable();
            $table->string('photo')->nullable();
            $table->tinyInteger('status')->default(1)->comment('1: Active, 0: Deactive');
            $table->softDeletes();
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
        Schema::dropIfExists('customers');
    }
}
