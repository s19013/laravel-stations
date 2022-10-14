<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Schedule;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('schedules', function (Blueprint $table) {
            $table->unsignedTinyInteger('screen_id')->after("movie_id");
        });

        // 新しく追加したカラムにデータをいれて置く
        $allSchedule = Schedule::all();
        foreach($allSchedule as $schedule){
            if (empty($schedule->screen_id)) {
                Schedule::where('id','=',$schedule->id)
                ->update(['screen_id' => 1]);
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
        Schema::table('schedules', function (Blueprint $table) {
            $table->dropColumn('screen_id');
        });
    }
};
