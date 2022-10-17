<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\User;
use App\Models\Reservation;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //reservationにあるnameとemailを取ってくる
        $nameAndEmailList = Reservation::select('name','email')->groupBy('name','email')->get();

        foreach($nameAndEmailList as $user){
            // userに同じのがなかったら
            if (!(User::where('name','=',$user->name)->where('email','=',$user->email)->exists())) {
                // usersに登録する
                User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    // パスワードはこちらで指定する
                    'password' => Hash::make('customers'),
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // 今作ったユーザーを削除
        //reservationにあるnameとemailを取ってくる
        $nameAndEmailList = Reservation::select('name','email')->groupBy('name','email')->get();

        foreach($nameAndEmailList as $user){
            // userに同じのがあったら
            if (User::where('name','=',$user->name)->where('email','=',$user->email)->exists()) {
                // usersを削除
                User::where('name','=',$user->name)->where('email','=',$user->email)->delete();
            }
        }
    }
};
