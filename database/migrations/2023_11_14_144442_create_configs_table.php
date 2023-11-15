<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configs', function (Blueprint $table) {
            $table->increments('id');
            $table->text('notification');
            $table->enum('trigger', [
                            'open_app',
                            'before_getting_servers_list',
                            'after_getting_servers_list',
                            'before_connect_to_server',
                            'after_connect_to_server',
                            'before_disconnect_srom_server',
                            'after_disconnect_from_server',
                            'before_close_app'
                        ])->default('before_getting_servers_list')->unique();
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
        Schema::dropIfExists('config');
    }
}
