<?php

namespace Tests\Feature\LaravelStations\Station18;

use App\Models\Movie;
use App\Models\Schedule;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminScheduleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @group station18
     */
    public function test管理者映画詳細にスケジュール一覧が表示されているか(): void
    {
        $count = 12;
        for ($i = 0; $i < $count; $i++) {
            $movieId = $this->createMovie('タイトル'.$i)->id;
            for ($j = 0; $j < 10; $j++) {
                Schedule::insert([
                    'movie_id' => $movieId,
                    'screen_id' =>1,
                    'start_time' => CarbonImmutable::now()->addHours($j),
                    'end_time' => CarbonImmutable::now()->addHours($j + 2),
                ]);
            }
        }
        $movies = Movie::all();
        foreach ($movies as $movie) {
            $response = $this->get('/admin/movies/'.$movie->id);
            $response->assertStatus(200);
            $response->assertSeeText($movie->title);
            $response->assertSee($movie->image_url);
            $response->assertSeeText($movie->published_year);
            $response->assertSeeText($movie->description);
            if ($movie->is_showing) {
                $response->assertSeeText('上映中');
            } else {
                $response->assertSeeText('上映予定');
            }
            foreach ($movie->schedules as $schedule) {
                $response->assertSeeText($schedule->screen_id);
                $response->assertSeeText($schedule->start_time);
                $response->assertSeeText($schedule->end_time);
            }
        }
        $response->assertDontSee('true');
        $response->assertDontSee('false');
    }

    /**
     * @group station18
     */
    public function test管理者映画スケジュール作成画面が表示されているか(): void
    {
        $movieId = $this->createMovie('タイトル')->id;
        $response = $this->get('/admin/movies/'.$movieId.'/schedules/create');
        $response->assertStatus(200);
    }

    /**
     * @group station18
     */
    public function test管理者映画スケジュール作成画面でスケジュールが作成されるか(): void
    {
        $this->assertScheduleCount(0);
        $movieId = $this->createMovie('タイトル')->id;
        $response = $this->post('/admin/movies/'.$movieId.'/schedules/store', [
            'movie_id' => $movieId,
            'screen_id' =>1,
            'start_time_date' => CarbonImmutable::now()->format('Y-m-d'),
            'start_time_time' => CarbonImmutable::now()->format('H:i'),
            'end_time_date' => CarbonImmutable::now()->addHour()->format('Y-m-d'),
            'end_time_time' => CarbonImmutable::now()->addHour()->format('H:i'),
        ]);
        $response->assertStatus(302);
        $this->assertScheduleCount(1);
    }

    /**
     * @group station18
     */
    public function testRequiredバリデーションが設定されているか(): void
    {
        $this->assertScheduleCount(0);
        $movieId = $this->createMovie('タイトル')->id;
        $response = $this->post('/admin/movies/'.$movieId.'/schedules/store', [
            'movie_id' => null,
            'screen_id' => null,
            'start_time_date' => null,
            'start_time_time' => null,
            'end_time_date' => null,
            'end_time_time' => null,
        ]);
        $response->assertStatus(302);
        $response->assertInvalid(['movie_id', 'screen_id','start_time_date', 'start_time_time', 'end_time_date', 'end_time_time']);
        $this->assertScheduleCount(0);
    }

    /**
     * @group station18
     */
    public function test日時フォーマットのバリデーションが設定されているか(): void
    {
        $this->assertScheduleCount(0);
        $movieId = $this->createMovie('タイトル')->id;
        $response = $this->post('/admin/movies/'.$movieId.'/schedules/store', [
            'movie_id' => $movieId,
            'screen_id' =>1,
            'start_time_date' => '2022/01/01',
            'start_time_time' => '01時00分',
            'end_time_date' => '2022/01/01',
            'end_time_time' => '03時00分',
        ]);
        $response->assertStatus(302);
        $response->assertInvalid(['start_time_date', 'start_time_time', 'end_time_date', 'end_time_time']);
        $this->assertScheduleCount(0);
    }

    /**
     * @group station18
     */
    public function testMaxフォーマットのバリデーションが設定されているか(): void
    {
        $this->assertScheduleCount(0);
        $movieId = $this->createMovie('タイトル')->id;
        $response = $this->post('/admin/movies/'.$movieId.'/schedules/store', [
            'movie_id' => $movieId,
            'screen_id' =>100,
            'start_time_date' => CarbonImmutable::now()->format('Y-m-d'),
            'start_time_time' => CarbonImmutable::now()->format('H:i'),
            'end_time_date' => CarbonImmutable::now()->addHour()->format('Y-m-d'),
            'end_time_time' => CarbonImmutable::now()->addHour()->format('H:i'),
        ]);
        $response->assertStatus(302);
        $response->assertInvalid(['screen_id']);
        $this->assertScheduleCount(0);
    }

    /**
     * @group station18
     */
    public function testMinフォーマットのバリデーションが設定されているか(): void
    {
        $this->assertScheduleCount(0);
        $movieId = $this->createMovie('タイトル')->id;
        $response = $this->post('/admin/movies/'.$movieId.'/schedules/store', [
            'movie_id' => $movieId,
            'screen_id' =>0,
            'start_time_date' => CarbonImmutable::now()->format('Y-m-d'),
            'start_time_time' => CarbonImmutable::now()->format('H:i'),
            'end_time_date' => CarbonImmutable::now()->addHour()->format('Y-m-d'),
            'end_time_time' => CarbonImmutable::now()->addHour()->format('H:i'),
        ]);
        $response->assertStatus(302);
        $response->assertInvalid(['screen_id']);
        $this->assertScheduleCount(0);
    }

    /**
     * @group station18
     */
    public function testNumericフォーマットのバリデーションが設定されているか(): void
    {
        $this->assertScheduleCount(0);
        $movieId = $this->createMovie('タイトル')->id;
        $response = $this->post('/admin/movies/'.$movieId.'/schedules/store', [
            'movie_id' => $movieId,
            'screen_id' => "aaa",
            'start_time_date' => CarbonImmutable::now()->format('Y-m-d'),
            'start_time_time' => CarbonImmutable::now()->format('H:i'),
            'end_time_date' => CarbonImmutable::now()->addHour()->format('Y-m-d'),
            'end_time_time' => CarbonImmutable::now()->addHour()->format('H:i'),
        ]);
        $response->assertStatus(302);
        $response->assertInvalid(['screen_id']);
        $this->assertScheduleCount(0);
    }

    private function assertScheduleCount(int $count): void
    {
        $scheduleCount = Schedule::count();
        $this->assertEquals($scheduleCount, $count);
    }

    /**
     * @group station18
     */
    public function test管理者映画編スケジュール集画面が表示されているか(): void
    {
        $movieId = $this->createMovie('タイトル')->id;
        $scheduleId = Schedule::insertGetId([
            'movie_id' => $movieId,
            'screen_id' =>1,
            'start_time' => CarbonImmutable::now(),
            'end_time' => CarbonImmutable::now()->addHours(2),
        ]);
        $response = $this->get('/admin/schedules/'.$scheduleId.'/edit');
        $response->assertStatus(200);
    }

    /**
     * @group station18
     */
    public function test管理者映画スケジュール編集画面で映画スケジュールが更新されるか(): void
    {
        $movieId = $this->createMovie('タイトル')->id;
        $startTime = new CarbonImmutable('2022-01-01 00:00:00');
        $endTime = new CarbonImmutable('2022-01-01 02:00:00');
        $scheduleId = Schedule::insertGetId([
            'movie_id' => $movieId,
            'screen_id' =>1,
            'start_time' => $startTime,
            'end_time' => $endTime,
        ]);
        $response = $this->patch('/admin/schedules/'.$scheduleId.'/update', [
            'movie_id' => $movieId,
            'screen_id' =>2,
            'start_time_date' => $startTime->addHours(2)->format('Y-m-d'),
            'start_time_time' => $startTime->addHours(2)->format('H:i'),
            'end_time_date' => $endTime->addHours(2)->format('Y-m-d'),
            'end_time_time' => $endTime->addHours(2)->format('H:i'),
        ]);
        $response->assertStatus(302);
        $updated = Schedule::find($scheduleId);
        $this->assertEquals($updated->start_time, $startTime->addHours(2));
        $this->assertEquals($updated->end_time, $endTime->addHours(2));
        $this->assertEquals($updated->screen_id, 2);
    }

    /**
     * @group station18
     */
    public function test更新時Requiredバリデーションが設定されているか(): void
    {
        $movieId = $this->createMovie('タイトル')->id;
        $startTime = new CarbonImmutable('2022-01-01 00:00:00');
        $endTime = new CarbonImmutable('2022-01-01 02:00:00');
        $scheduleId = Schedule::insertGetId([
            'movie_id' => $movieId,
            'screen_id' =>1,
            'start_time' => $startTime,
            'end_time' => $endTime,
        ]);
        $response = $this->patch('/admin/schedules/'.$scheduleId.'/update', [
            'movie_id' => null,
            'screen_id' => null,
            'start_time_date' => null,
            'start_time_time' => null,
            'end_time_date' => null,
            'end_time_time' => null,
        ]);
        $response->assertStatus(302);
        $response->assertInvalid(['movie_id', 'screen_id','start_time_date', 'start_time_time', 'end_time_date', 'end_time_time']);
    }

    /**
     * @group station18
     */
    public function test更新時日時フォーマットのバリデーションが設定されているか(): void
    {
        $movieId = $this->createMovie('タイトル')->id;
        $startTime = new CarbonImmutable('2022-01-01 00:00:00');
        $endTime = new CarbonImmutable('2022-01-01 02:00:00');
        $scheduleId = Schedule::insertGetId([
            'movie_id' => $movieId,
            'screen_id' =>1,
            'start_time' => $startTime,
            'end_time' => $endTime,
        ]);
        $response = $this->patch('/admin/schedules/'.$scheduleId.'/update', [
            'movie_id' => $movieId,
            'screen_id' =>2,
            'start_time_date' => '2022/01/01',
            'start_time_time' => '01時00分',
            'end_time_date' => '2022/01/01',
            'end_time_time' => '03時00分',
        ]);
        $response->assertStatus(302);
        $response->assertInvalid(['start_time_date', 'start_time_time', 'end_time_date', 'end_time_time']);
    }

    /**
     * @group station18
     */
    public function test更新時minのバリデーションが設定されているか(): void
    {
        $movieId = $this->createMovie('タイトル')->id;
        $startTime = new CarbonImmutable('2022-01-01 00:00:00');
        $endTime = new CarbonImmutable('2022-01-01 02:00:00');
        $scheduleId = Schedule::insertGetId([
            'movie_id' => $movieId,
            'screen_id' =>1,
            'start_time' => $startTime,
            'end_time' => $endTime,
        ]);
        $response = $this->patch('/admin/schedules/'.$scheduleId.'/update', [
            'movie_id' => $movieId,
            'screen_id' =>0,
            'start_time_date' => $startTime->addHours(2)->format('Y-m-d'),
            'start_time_time' => $startTime->addHours(2)->format('H:i'),
            'end_time_date' => $endTime->addHours(2)->format('Y-m-d'),
            'end_time_time' => $endTime->addHours(2)->format('H:i'),
        ]);
        $response->assertStatus(302);
        $response->assertInvalid(['screen_id']);
    }

    /**
     * @group station18
     */
    public function test更新時Numericのバリデーションが設定されているか(): void
    {
        $movieId = $this->createMovie('タイトル')->id;
        $startTime = new CarbonImmutable('2022-01-01 00:00:00');
        $endTime = new CarbonImmutable('2022-01-01 02:00:00');
        $scheduleId = Schedule::insertGetId([
            'movie_id' => $movieId,
            'screen_id' =>1,
            'start_time' => $startTime,
            'end_time' => $endTime,
        ]);
        $response = $this->patch('/admin/schedules/'.$scheduleId.'/update', [
            'movie_id' => $movieId,
            'screen_id' =>"aaa",
            'start_time_date' => $startTime->addHours(2)->format('Y-m-d'),
            'start_time_time' => $startTime->addHours(2)->format('H:i'),
            'end_time_date' => $endTime->addHours(2)->format('Y-m-d'),
            'end_time_time' => $endTime->addHours(2)->format('H:i'),
        ]);
        $response->assertStatus(302);
        $response->assertInvalid(['screen_id']);
    }


    private function createMovie(string $title): Movie
    {
        $movieId = Movie::insertGetId([
            'title' => $title,
            'image_url' => 'https://techbowl.co.jp/_nuxt/img/6074f79.png',
            'published_year' => 2000,
            'description' => '概要',
            'is_showing' => false
        ]);
        return Movie::find($movieId);
    }

    /**
     * @group station18
     */
    public function testスケジュールを削除できるか(): void
    {
        $movieId = $this->createMovie('タイトル')->id;
        $startTime = new CarbonImmutable('2022-01-01 00:00:00');
        $endTime = new CarbonImmutable('2022-01-01 02:00:00');
        $scheduleId = Schedule::insertGetId([
            'movie_id' => $movieId,
            'screen_id' =>1,
            'start_time' => $startTime,
            'end_time' => $endTime,
        ]);
        $this->assertScheduleCount(1);
        $response = $this->delete('/admin/schedules/'.$scheduleId.'/destroy');
        $response->assertStatus(302);
        $this->assertScheduleCount(0);
    }

    /**
     * @group station18
     */
    public function test削除対象が存在しない時404が返るか(): void
    {
        $response = $this->delete('/admin/schedules/1/destroy');
        $response->assertStatus(404);
    }
}

