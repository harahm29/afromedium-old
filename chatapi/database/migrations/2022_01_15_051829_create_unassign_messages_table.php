<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnassignMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unassign_messages', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('user_id')->nullable();
            $table->BigInteger('msg_id')->nullable();
            $table->BigInteger('notify')->default(0)->nullable();
            $table->text('time')->nullable();
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
        Schema::dropIfExists('unassign_messages');
    }
}
