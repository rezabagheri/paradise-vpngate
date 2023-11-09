<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('server', function (Blueprint $table) {
            $table->increments('id');
            $table->string('host_name');
            $table->string('ip');
            $table->integer('score')->index()->nullable();
            $table->integer('ping')->index()->nullable();
            $table->bigInteger('speed')->index()->nullable();
            $table->string('country_long')->nullable();
            $table->string('country_short')->nullable();
            $table->integer('num_vpn_sessions')->index()->nullable();
            $table->integer('uptime')->nullable();
            $table->integer('total_users')->index()->nullable();
            $table->bigInteger('total_traffic')->index()->nullable();
            $table->string('log_type')->nullable();
            $table->string('operator')->nullable();
            $table->string('message')->nullable();
            $table->text('openvpn_config_data_base64')->nullable();
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
        Schema::dropIfExists('server');
    }
}
