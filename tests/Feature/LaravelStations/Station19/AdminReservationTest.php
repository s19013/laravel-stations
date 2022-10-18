<?php

namespace Tests\Feature\LaravelStations\Station19;

use App\Models\User;
use App\Models\Movie;
use App\Models\Sheet;
use App\Models\Reservation;
use App\Models\Schedule;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminReservationTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    /**
     * @group station19
     */
    public function test管理者予約一覧が表示されているか(): void
    {
        $user = User::factory()->create();
        $count = 12;
        for ($i = 0; $i < $count; $i++) {
            $movieId = $this->createMovie('タイトル'.$i)->id;
            Reservation::insert([
                'screening_date' => new CarbonImmutable('2050-01-01'),
                'schedule_id'    => Schedule::insertGetId([
                    'movie_id'   => $movieId,
                    'screen_id'  =>1,
                    'start_time' => new CarbonImmutable('2050-01-01 00:00:00'),
                    'end_time'   => new CarbonImmutable('2050-01-01 02:00:00'),
                ]),
                'sheet_id' => $i + 1,
                'user_id'    => $user->id,
            ]);
        }
        $response = $this->get('/admin/reservations/');
        $response->assertStatus(200);

        $reservations = Reservation::all();
        foreach ($reservations as $reservation) {
            $response->assertSee($reservation->screening_date);
            $response->assertSee($reservation->user->name);
            $response->assertSee($reservation->user->email);
            $response->assertSee(strtoupper($reservation->sheet->row.$reservation->sheet->column));
        }
    }

    /**
     * @group station19
     */
    public function test管理者予約一覧で上映終了の映画が非表示となっているか(): void
    {
        $user = User::factory()->create();
        $count = 12;
        for ($i = 0; $i < $count; $i++) {
            $movieId = $this->createMovie('タイトル'.$i)->id;
            Reservation::insert([
                'screening_date' => new CarbonImmutable('2020-01-01'),
                'schedule_id' => Schedule::insertGetId([
                    'movie_id' => $movieId,
                    'screen_id' =>1,
                    'start_time' => new CarbonImmutable('2020-01-01 00:00:00'),
                    'end_time' => new CarbonImmutable('2020-01-01 02:00:00'),
                ]),
                'sheet_id' => $i + 1,
                'user_id'    => $user->id,
            ]);
        }
        $response = $this->get('/admin/reservations/');
        $response->assertStatus(200);

        $reservations = Reservation::all();
        foreach ($reservations as $reservation) {
            $response->assertDontSee($reservation->screening_date);
            $response->assertDontSee($reservation->user->name);
            $response->assertDontSee($reservation->user->email);
            $response->assertDontSee(strtoupper($reservation->sheet->row.$reservation->sheet->column));
        }
    }

    /**
     * @group station19
     */
    public function test管理者予約作成画面が表示されているか(): void
    {
        $response = $this->get('/admin/reservations/create');
        $response->assertStatus(200);
    }

    /**
     * @group station19
     */
    public function test管理者予約作成画面で予約が作成されるか(): void
    {
        $this->assertReservationCount(0);
        $movieId = $this->createMovie('タイトル')->id;
        $scheduleId = $this->createSchedule($movieId)->id;
        $user = User::factory()->create();

        // 仕様書では /admin/reservations/storeなんだけど
        $response = $this->post('/admin/reservations/store', [
            'movie_id' => $movieId,
            // なぜscreening_dateがないのか
            'screening_date' => CarbonImmutable::now()->format('Y-m-d'),
            'schedule_id' => $scheduleId,
            'sheet_id' => Sheet::first()->id,
            'user_id'  => $user->id,
        ]);
        $response->assertStatus(302);
        $this->assertReservationCount(1);
    }

    /**
     * @group station19
     */
    public function testRequiredバリデーションが設定されているか(): void
    {
        $this->assertReservationCount(0);
        $response = $this->post('/admin/reservations/store', [
            'movie_id' => null,
            'schedule_id' => null,
            'sheet_id' => null,
            'user_id' => null,
        ]);
        $response->assertStatus(302);
        $response->assertInvalid(['movie_id', 'schedule_id', 'sheet_id', 'user_id']);
        $this->assertReservationCount(0);
    }

    private function assertReservationCount(int $count): void
    {
        $reservationCount = Reservation::count();
        $this->assertEquals($reservationCount, $count);
    }

    /**
     * @group station19
     */
    public function test管理者映集予約画面が表示されているか(): void
    {
        $user = User::factory()->create();
        $movieId = $this->createMovie('タイトル')->id;
        $scheduleId = $this->createSchedule($movieId)->id;
        $reservationId = Reservation::insertGetId([
            'screening_date' => new CarbonImmutable(),
            'schedule_id' => $scheduleId,
            'sheet_id' => 1,
            'user_id'  => $user->id
        ]);
        $response = $this->get('/admin/reservations/'.$reservationId.'/edit');
        $response->assertStatus(200);
    }

    /**
     * @group station19
     */
    public function test管理者予約編集画面で映画予約が更新されるか(): void
    {
        $user = User::factory()->create();
        $anothorUser = User::factory()->create();
        $movieId = $this->createMovie('タイトル')->id;
        $scheduleId = $this->createSchedule($movieId)->id;
        $reservationId = Reservation::insertGetId([
            'screening_date' => new CarbonImmutable(),
            'schedule_id' => $scheduleId,
            'sheet_id' => 1,
            'user_id'  => $user->id
        ]);
        $response = $this->patch('/admin/reservations/'.$reservationId, [
            'movie_id' => $movieId,
            'schedule_id' => $scheduleId,
            'sheet_id' => 2,
            // screening_dateがないので追加
            'screening_date' => CarbonImmutable::now()->format('Y-m-d'),
            'user_id'  => $anothorUser->id
        ]);
        $response->assertStatus(302);
        $updated = Reservation::find($reservationId);
        $this->assertEquals($updated->user_id, $anothorUser->id);
        $this->assertEquals($updated->sheet_id, 2);
    }

    /**
     * @group station19
     */
    public function test更新時Requiredバリデーションが設定されているか(): void
    {
        $user = User::factory()->create();
        $movieId = $this->createMovie('タイトル')->id;
        $scheduleId = $this->createSchedule($movieId)->id;
        $reservationId = Reservation::insertGetId([
            'screening_date' => new CarbonImmutable(),
            'schedule_id' => $scheduleId,
            'sheet_id' => 1,
            'user_id'  => $user->id
        ]);
        $response = $this->patch('/admin/reservations/'.$reservationId, [
            'movie_id' => null,
            'schedule_id' => null,
            'sheet_id' => null,
            'user_id' => null,
        ]);
        $response->assertStatus(302);
        $response->assertInvalid(['movie_id', 'schedule_id', 'sheet_id','user_id']);
    }

    private function createMovie(string $title): Movie
    {
        $movieId = Movie::insertGetId([
            'title' => $title,
            'image_url' => 'https://techbowl.co.jp/_nuxt/img/6074f79.png',
            'published_year' => 2000,
            'description' => '概要',
            'is_showing' => rand(0,1),
        ]);
        return Movie::find($movieId);
    }

    private function createSchedule(int $movieId): Schedule
    {
        $scheduleId = Schedule::insertGetId([
            'movie_id' => $movieId,
            'screen_id' =>1,
            'start_time' => new CarbonImmutable(),
            'end_time' => new CarbonImmutable(),
        ]);
        return Schedule::find($scheduleId);
    }

    /**
     * @group station19
     */
    public function test予約を削除できるか(): void
    {
        $user = User::factory()->create();
        $movieId = $this->createMovie('タイトル')->id;
        $scheduleId = $this->createSchedule($movieId)->id;
        $reservationId = Reservation::insertGetId([
            'screening_date' => new CarbonImmutable(),
            'schedule_id' => $scheduleId,
            'sheet_id' => 1,
            'user_id'  => $user->id,
        ]);
        $this->assertReservationCount(1);
        $response = $this->delete('/admin/reservations/'.$reservationId);
        $response->assertStatus(302);
        $this->assertReservationCount(0);
    }

    /**
     * @group station19
     */
    public function test削除対象が存在しない時404が返るか(): void
    {
        $response = $this->delete('/admin/reservations/1');
        $response->assertStatus(404);
    }
}
