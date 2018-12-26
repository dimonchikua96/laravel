<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicePointGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sp_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('state_id',20);
            $table->string('type_id',20);
            $table->string('branch',4);
            $table->timestamps();

            $table->foreign('state_id')->references('state')->on('sp_states');
            $table->foreign('type_id')->references('type')->on('sp_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sp_groups');
    }
}
