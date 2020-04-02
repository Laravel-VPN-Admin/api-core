<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('servers', static function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('hostname')->index();
            $table->string('ipv4')->nullable()->index();
            $table->string('ipv6')->nullable()->index();
            $table->string('token')->nullable();
            $table->dateTime('last_echo_at')->nullable();

            $table->bigInteger('configuration_id')->unsigned()->nullable();
            $table->foreign('configuration_id')->references('id')->on('configurations')->onDelete('set null');

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
        Schema::dropIfExists('servers');
    }
}
