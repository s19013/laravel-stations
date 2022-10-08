<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Movie;

class MovieModelTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        $this->assertTrue(true);
    }

    // 期待
    // すべてのデータを取ってくる
    public function test_search_すべてのデータを取ってくる()
    {
        $movieModel = new Movie();

        // 公開非公開合わせて10個登録する
        Movie::factory()->count(5)->create([ 'is_showing' => '1' ]);
        Movie::factory()->count(5)->create([ 'is_showing' => '0' ]);

        print(Movie::select('id','is_showing')->get());

        // 検索結果を取り出す
        $response = $movieModel->search((object)[
            'keyword' => null,
            'is_showing'  => null,
        ]);

        echo '\n';
        print($response);

        // 10個とってこれているか
        $this->assertCount(10, $response);
    }

    // 期待
    // 公開中のデータを取ってくる
    // 条件
    // is_showing = '1'
    public function test_search_公開中のデータを取ってくる()
    {
        $movieModel = new Movie();

        // 公開を4個
        Movie::factory()->count(4)->create([ 'is_showing' => '1' ]);
        // 非公開を5個登録
        Movie::factory()->count(5)->create([ 'is_showing' => '0' ]);

        // 検索結果を取り出す
        $response = $movieModel->search((object)[
            'keyword' => null,
            'is_showing'  => '1',
        ]);

        // 4個とってこれているか
        $this->assertCount(4, $response);
    }

    // 期待
    // 非公開のデータを取ってくる
    // 条件
    // is_showing = 'not 1'
    public function test_search_非公開のデータを取ってくる()
    {
        $movieModel = new Movie();

        // 公開を4個
        Movie::factory()->count(4)->create([ 'is_showing' => '1' ]);
        // 非公開を5個登録
        Movie::factory()->count(5)->create([ 'is_showing' => '0' ]);

        // 検索結果を取り出す
        $response = $movieModel->search((object)[
            'keyword' => null,
            'is_showing'  => '0',
        ]);

        // 4個とってこれているか
        $this->assertCount(5, $response);
    }

    // 期待
    // タイトルもしくは概要に'abc'という文字列が入っているデータを取ってくる
    // 条件
    // keyword = 'abc'
    // 公開非公開は無視
    public function test_search_キーワードにあうデータを取ってくる()
    {
        $movieModel = new Movie();
        // ヒットするデータ
        Movie::factory()->create(['title' => 'abcde']);
        Movie::factory()->create(['title' => 'qwrabcrty']);
        Movie::factory()->create(['description' => 'abcde']);
        Movie::factory()->create(['description' => 'qwrabcrty']);

        //ダミーデータ
        Movie::factory()->count(2)->create(['is_showing' => '1']);
        Movie::factory()->count(2)->create(['is_showing' => '0']);

        // 検索結果を取り出す
        $response = $movieModel->search((object)[
            'keyword' => 'abc',
            'is_showing'  => null,
        ]);

        $hitTitleCount = 0;
        $hitDescriptionCount = 0;

        foreach ($response as $r) {
            // 正規表現で本当にタイトルか概要に'abc'が入っているか確かめる
            if (preg_match('*abc*', $r->title)===1) { $hitTitleCount += 1; }
            if (preg_match('*abc*', $r->description)===1) { $hitDescriptionCount += 1; }
        }

        // タイトル､概要にヒットするデータを2つずついれたから
        $this->assertSame(2,$hitTitleCount);
        $this->assertSame(2,$hitDescriptionCount);

    }

    // 期待
    // タイトルもしくは概要に'abc'という文字列が入っているデータを取ってくる
    // 条件
    // keyword = 'abc'
    // 公開
    public function test_search_キーワードにあうデータを取ってくる_公開データ()
    {
        $movieModel = new Movie();
        // ヒットするデータ
        Movie::factory()->create([
            'title' => 'abcde',
            'is_showing' => '1'
        ]);
        Movie::factory()->create([
            'description' => 'qwrabcrty',
            'is_showing' => '1'
        ]);

        // ダミー
        Movie::factory()->create([
            'title' => 'qwrabcrty',
            'is_showing' => '0'
        ]);
        Movie::factory()->create([
            'description' => 'abcde',
            'is_showing' => '0'
        ]);

        //ダミーデータ
        Movie::factory()->count(2)->create(['is_showing' => '1']);
        Movie::factory()->count(2)->create(['is_showing' => '0']);

        // 検索結果を取り出す
        $response = $movieModel->search((object)[
            'keyword' => 'abc',
            'is_showing'  => '1',
        ]);

        $hitTitleCount = 0;
        $hitDescriptionCount = 0;

        foreach ($response as $r) {
            // 正規表現で本当にタイトルか概要に'abc'が入っているか確かめる
            if (preg_match('*abc*', $r->title)===1) { $hitTitleCount += 1; }
            if (preg_match('*abc*', $r->description)===1) { $hitDescriptionCount += 1; }
        }

        // タイトル､概要にヒットするデータを1つずついれたから
        $this->assertSame(1,$hitTitleCount);
        $this->assertSame(1,$hitDescriptionCount);

    }

    // 期待
    // タイトルもしくは概要に'abc'という文字列が入っているデータを取ってくる
    // 条件
    // keyword = 'abc'
    // 非公開
    public function test_search_キーワードにあうデータを取ってくる_非公開データ()
    {
        $movieModel = new Movie();
        // ヒットするデータ
        Movie::factory()->create([
            'title' => 'qwrabcrty',
            'is_showing' => '0'
        ]);
        Movie::factory()->create([
            'description' => 'abcde',
            'is_showing' => '0'
        ]);

        // ダミー
        Movie::factory()->create([
            'title' => 'abcde',
            'is_showing' => '1'
        ]);
        Movie::factory()->create([
            'description' => 'qwrabcrty',
            'is_showing' => '1'
        ]);

        //ダミーデータ
        Movie::factory()->count(2)->create(['is_showing' => '1']);
        Movie::factory()->count(2)->create(['is_showing' => '0']);

        // 検索結果を取り出す
        $response = $movieModel->search((object)[
            'keyword' => 'abc',
            'is_showing'  => '0',
        ]);

        $hitTitleCount = 0;
        $hitDescriptionCount = 0;

        foreach ($response as $r) {
            // 正規表現で本当にタイトルか概要に'abc'が入っているか確かめる
            if (preg_match('*abc*', $r->title)===1) { $hitTitleCount += 1; }
            if (preg_match('*abc*', $r->description)===1) { $hitDescriptionCount += 1; }
        }

        // タイトル､概要にヒットするデータを1つずついれたから
        $this->assertSame(1,$hitTitleCount);
        $this->assertSame(1,$hitDescriptionCount);

    }
}

