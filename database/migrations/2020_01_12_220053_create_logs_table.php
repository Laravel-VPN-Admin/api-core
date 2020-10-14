<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('logs', static function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('message')->nullable();
            $table->integer('code');

            $table->bigInteger('server_id')->unsigned()->nullable();
            $table->foreign('server_id')->references('id')->on('servers')->onDelete('set null');

            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
}
