<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reservations', function (Blueprint $table) {
            // 生成時のみnullableにする(じゃないとエラー吐かれる)
            $table->unsignedBigInteger('user_id')->nullable();

            // 外部
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });

        // usersテーブルを参照して値を入れる

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
    }
};
