<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\User;
use App\Models\Reservation;

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
            // 最初だけnullable
            $table->unsignedBigInteger('user_id')->nullable();
        });

        // usersテーブルを参照して値を入れる
        $allUser = User::all();

        foreach($allUser as $user){
            Reservation::where('name','=',$user->name)
            ->where('email','=',$user->email)
            ->update(['user_id' => $user->id]);
        }

        // 外部は後から追加
        Schema::table('reservations', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->unsignedBigInteger('user_id')->nullable(false)->change();
        });
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
