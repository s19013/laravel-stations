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
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            // ユニークを追加するには文字数の制限をかけないと行けない
            // 別のマイグレーションファイルに書いてマイグレーション実行するには->change()が必要になる
            // ->change()を使うには`doctrine/dbal package.`をインストールする必要がある
            // 面倒､今はまだ最初期なので今までのマイグレーションをロールバックしてこのファイルを変更するようにする
            $table->text('title',1000)->unique()->comment('タイトル');
            $table->text('title')->comment('タイトル');
            $table->text('image_url')->comment('写真のurl');
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
        Schema::dropIfExists('movies');
    }
};
