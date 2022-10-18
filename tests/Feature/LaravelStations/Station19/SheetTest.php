<?php

namespace Tests\Feature\LaravelStations\Station19;

use App\Models\Movie;
use App\Models\Reservation;
use App\Models\Schedule;
use App\Models\Sheet;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SheetTest extends TestCase
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
    public function testSeedコマンドでマスターデータが作成されるか(): void
    {
        $this->assertEquals(Sheet::count(), 15);
    }

    /**
     * @group station19
     */
    public function test座席一覧画面に全ての座席が表示されるか(): void
    {
        $response = $this->get('/sheets');
        $response->assertStatus(200);
        $sheets = Sheet::all();
        foreach ($sheets as $sheet) {
            $response->assertSeeText($sheet->row .'-'. $sheet->column);
        }
    }

    /**
     * @group station19
     */
    // 条件
    // ログインしている状態
    public function test座席予約画面が表示されるか(): void
    {
        $user = User::factory()->create();
        [$movieId, $scheduleId] = $this->createMovieAndSchedule();
        $response = $this->actingAs($user)
        ->get('/movies/'.$movieId.'/schedules/'.$scheduleId.'/sheets?screening_date='.CarbonImmutable::now()->format('Y-m-d'));
        $response->assertStatus(200);
    }

    /**
     * @group station19
     */
    // 期待
    // 座席予約画面が表示されずにログインページに飛ぶか
    // 条件
    // ログインしていない状態
    public function test座席予約画面が表示されずにログインページに飛ぶか(): void
    {
        [$movieId, $scheduleId] = $this->createMovieAndSchedule();
        $response = $this->get('/movies/'.$movieId.'/schedules/'.$scheduleId.'/sheets?screening_date='.CarbonImmutable::now()->format('Y-m-d'));
        $response->assertStatus(302);
        $response->assertSee('users/login');
    }

    /**
     * @group station19
     */
    public function test座席予約画面がエラー時400を返すか(): void
    {
        $user = User::factory()->create();
        [$movieId, $scheduleId] = $this->createMovieAndSchedule();
        $response = $this->actingAs($user)
        ->get('/movies/'.$movieId.'/schedules/'.$scheduleId.'/sheets');
        $response->assertStatus(400);
    }

    /**
     * @group station19
     */
    // public function test予約ページが表示されるか(): void
    // {
    //     [$movieId, $scheduleId] = $this->createMovieAndSchedule();
    //     $response = $this->get('/movies/'.$movieId.'/schedules/'.$scheduleId.'/reservations/create?screening_date='.CarbonImmutable::now()->format('Y-m-d').'&sheetId='.Sheet::first()->id);
    //     $response->assertStatus(200);
    // }

    /**
     * @group station19
     */
    // public function test予約ページがエラー時400を返すか(): void
    // {
    //     [$movieId, $scheduleId] = $this->createMovieAndSchedule();
    //     $response = $this->get('/movies/'.$movieId.'/schedules/'.$scheduleId.'/reservations/create');
    //     $response->assertStatus(400);
    //     $response = $this->get('/movies/'.$movieId.'/schedules/'.$scheduleId.'/reservations/create?screening_date='.CarbonImmutable::now()->format('Y-m-d'));
    //     $response->assertStatus(400);
    //     $response = $this->get('/movies/'.$movieId.'/schedules/'.$scheduleId.'/reservations/create?sheetId='.Sheet::first()->id);
    //     $response->assertStatus(400);
    // }

    /**
     * @group station19
     */
    public function test予約を保存できるかどうか(): void
    {
        $user = User::factory()->create();
        $this->assertReservationCount(0);
        [$movieId, $scheduleId] = $this->createMovieAndSchedule();
        $response = $this->actingAs($user)
        ->post('/reservations/store', [
            'schedule_id' => $scheduleId,
            'sheet_id' => Sheet::first()->id,
            // 'user_id'  => $user->id,
            'screening_date' => CarbonImmutable::now()->format('Y-m-d'),
        ]);
        $response->assertStatus(302);
        $this->assertReservationCount(1);
    }

    /**
     * @group station19
     */
    public function test予約のrequireバリデーションチェック(): void
    {
        $this->assertReservationCount(0);
        [$movieId, $scheduleId] = $this->createMovieAndSchedule();
        $response = $this->post('/reservations/store', [
            'schedule_id' => null,
            'sheet_id' => null,
            // 'user_id' => null,
            'screening_date' => null,
        ]);
        $response->assertStatus(302);
        $response->assertInvalid(['schedule_id', 'sheet_id', 'screening_date']);
        $this->assertReservationCount(0);
    }

    /**
     * @group station19
     */
    public function test予約重複時時エラーを返す(): void
    {
        $user = User::factory()->create();
        [$movieId, $scheduleId] = $this->createMovieAndSchedule();
        Reservation::insert([
            'schedule_id' => $scheduleId,
            'sheet_id' => Sheet::first()->id,
            'user_id'  => $user->id,
            'screening_date' => CarbonImmutable::now()->format('Y-m-d'),
        ]);
        $this->assertReservationCount(1);

        $anotherUser = User::factory()->create();
        $response = $this->actingAs($anotherUser)
        ->post('/reservations/store', [
            'schedule_id' => $scheduleId,
            'sheet_id' => Sheet::first()->id,
            // 'user_id'  => $anotherUser->id,
            'screening_date' => CarbonImmutable::now()->format('Y-m-d'),
        ]);
        $response->assertStatus(302);
        $this->assertReservationCount(1);
    }

    /**
     * @group station19
     */
    public function testDBのUnique制限がかかっているかどうか(): void
    {
        $user = User::factory()->create();
        [$movieId, $scheduleId] = $this->createMovieAndSchedule();
        Reservation::insert([
            'schedule_id' => $scheduleId,
            'sheet_id' => Sheet::first()->id,
            'user_id'  => $user->id,
            'screening_date' => CarbonImmutable::now()->format('Y-m-d'),
        ]);
        $this->assertReservationCount(1);
        try {
            Reservation::insert([
                'schedule_id' => $scheduleId,
                'sheet_id' => Sheet::first()->id,
                'user_id'  => $user->id,
                'screening_date' => CarbonImmutable::now()->format('Y-m-d'),
            ]);
            $this->fail();
        } catch (\Exception $e) {
            $this->assertTrue(true);
        }
        $this->assertReservationCount(1);
    }

    /**
     * @group station19
     */
    // public function test既に存在する予約の場合予約ページが400となるか(): void
    // {
    //     [$movieId, $scheduleId] = $this->createMovieAndSchedule();
    //     Reservation::insert([
    //         'screening_date' => new CarbonImmutable(),
    //         'schedule_id' => $scheduleId,
    //         'sheet_id' => Sheet::first()->id,
    //         'email' => 'sample@techbowl.com',
    //         'name' => 'サンプルユーザー',
    //     ]);
    //     $response = $this->get('/movies/'.$movieId.'/schedules/'.$scheduleId.'/reservations/create?screening_date='.CarbonImmutable::now()->format('Y-m-d').'&sheetId='.Sheet::first()->id);
    //     $response->assertStatus(400);
    // }

    private function createMovieAndSchedule()
    {
        $movieId = Movie::insertGetId([
            'title' => 'タイトル',
            'image_url' => 'https://techbowl.co.jp/_nuxt/img/6074f79.png',
            'published_year' => 2000,
            'description' => '概要',
            'is_showing' => (bool)random_int(0, 1),
        ]);
        $startTime = CarbonImmutable::now();
        $scheduleId = Schedule::insertGetId([
            'movie_id' => $movieId,
            'screen_id' =>1,
            'start_time' => $startTime,
            'end_time' => $startTime->addHours(2),
        ]);
        return [$movieId, $scheduleId];
    }

    private function assertReservationCount(int $count): void
    {
        $this->assertEquals($count, Reservation::count());
    }
}
