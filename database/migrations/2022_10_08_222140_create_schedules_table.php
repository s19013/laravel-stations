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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('movie_id');
            // $table->time('start_time');
            // $table->time('end_time');
            // timeだと時間だけしか保存しないもよう 日付も保存したいなら他のやつを使うと良いらしい
            // ちなみにrubyだと timeで時間と日付
            $table->DateTime('start_time');
            $table->DateTime('end_time');
            $table->timestamps();

            // 外部キー
            // cascadeをつけたから紐づけた親要素のMovieが消えれば子要素のスケジュールも消える
            $table->foreign('movie_id')->references('id')->on('movies')->cascadeOnDelete();;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedules');
    }
};

