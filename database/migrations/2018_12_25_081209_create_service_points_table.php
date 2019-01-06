<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicePointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sp_points', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code',20)->unique();
            $table->string('name',200);
            $table->string('state_id',20);
            $table->integer('group_id');

            $table->string('operator_ldap',15)->nullable()->unique()->default(null);
            $table->dateTime('operator_date')->nullable()->default(null);
            $table->integer('sort_order');
            $table->timestamps();

            $table->foreign('state_id')->references('state')->on('sp_states');
            $table->foreign('group_id')->references('id')->on('sp_groups');
          });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sp_points');
    }
}
