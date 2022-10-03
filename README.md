# 環境構築
[スライド形式マニュアル](https://docs.google.com/presentation/d/16g_T-qrpcZx8OKeWB6QUUZFHzkfAjCp3EEJg74mE26Q/edit?usp=sharing)

1. Docker Desktop

上記は必ずインストールした上で始めてください。

## リポジトリのFork
1. 画面右上にあるForkをクリックします。
2. クリックすると「Create a new fork」というページに飛ぶので、そのページにある緑色の「create fork」というボタンをクリックします。

## Macにおける初期設定
1. Terminal.app を開きます
2. `git clone https://github.com/{{yourGitHubID}}/laravel-stations.git` で自分のPCにこのリポジトリをダウンロードします。
3. `cd laravel-stations` でカレントディレクトリをダウンロードしたディレクトリである `laravel-stations` に移動します。
4. `cp .env.example .env` を実行して、 `.env` ファイルを作成します。
5. `docker compose build --no-cache` を実行します。

↓のような表示が流れていくことを確認してください

![d161a9cadf8e80bcaa66273d3f2ee10b](https://user-images.githubusercontent.com/16362021/149891105-ef42351e-006b-4985-95dc-a8c210ef19ea.gif)

6. `docker compose up -d` を実行します。
7. `docker compose exec php-container composer install` を実行します。
8. `docker compose ps` というコマンドを打って次のような表示になっていれば、ひとまずOKです！

![スクリーンショット 2022-05-23 11 16 39](https://user-images.githubusercontent.com/16362021/169730921-fc40f8af-b8df-4074-adad-cba13b4a2d48.png)

8. 3分ほど待ってから、 http://localhost:8888 を開いて次のような表示になっていることを確認してください。

![スクリーンショット 2022-03-18 16 09 00](https://user-images.githubusercontent.com/16362021/158953853-a4105a2c-b042-46af-83cf-e1737cd51912.png)

↑ここに至るまでに時間を待たずに http://localhost:8888 を開くとしばらく画面がエラーとなっている状態になります。
具体的には次のいずれか2つような画面です。その際には数分待ってからリロードしてみてください。

![スクリーンショット 2022-05-23 11 18 45](https://user-images.githubusercontent.com/16362021/169731216-395ab51b-85b1-4746-a825-63ae81c2a582.png)
![スクリーンショット 2022-05-23 11 19 44](https://user-images.githubusercontent.com/16362021/169731217-e27394e9-7f4a-46a2-b314-86c225194894.png)

## Windows における初期設定

Windows での初期設定を行うためには、キャラクターユーザーインターフェイス（CUI）の操作を行う必要があります。

#### PowerShell の起動方法

Windows では、**PowerShell**とよばれるシェルが標準で搭載されています。シェルはキャラクターユーザーインターフェイスの 1 つで、ファイルやディレクトリの操作などに特化したものです。

PowerShell を起動するには、スタートボタン（左下にある Windows のロゴ）を右クリックするか、`Win-X`キーを押して以下のメニューを表示してください。
管理者権限を必要とする場合は「Windows PowerShell (管理者)(A)」、それ以外の場合は「Windows PowerShell(I)」をクリックしましょう。

![image](https://user-images.githubusercontent.com/298748/115985113-42199a00-a5e5-11eb-9f7c-85c19f73666b.png)

#### PowerShell を操作する

PowerShell を起動すると、以下のような画面が出てきます。

![image](https://user-images.githubusercontent.com/298748/115985231-d2f07580-a5e5-11eb-9dd8-5e9751df590b.png)

シェルは、上のような**端末**と呼ばれる画面に文字を入力することにより操作します。試しに文字を入力してみましょう。
`>`以下に入力した文字が現れます。`>`のように、入力待ちになっていることを表す記号を**プロンプト**と言います。

プロンプトに文字を入力し`Enter`キーを押すと、コンピュータはその内容（指示）に合わせて動作します。このような指示を**コマンド**と呼びます。コマンドにはさまざまな決まりがありますが、ここではその説明は割愛します。

つぎに、コピー＆ペーストのやり方について説明します。ブラウザ上でコピー（`Ctrl-c`）したものを貼り付けるには、端末上で**右クリック**します。また、端末上の文字をコピーしたいときには、コピーしたい部分をドラッグで選択し**右クリック**します。メモ帳などにペースト（`Ctrl-v`）して正しくコピーできるか確認するといいでしょう。

```powershell
winver
```

では試しに、上のコマンドをコピー＆ペーストして`Enter`キーを押しましょう。以下の画面が出たら成功です。

![image](https://user-images.githubusercontent.com/298748/115985269-0206e700-a5e6-11eb-9394-9a50ed6e9d49.png)

#### 作業ディレクトリ

シェルには、**作業ディレクトリ**というものが存在します。

ファイルやディレクトリがどこにあるかを**パス**と言われる文字列で表現しますが、すべて絶対パスで指定していては煩わしいです。
作業ディレクトリを決めておくと、そのディレクトリとの相対位置でパスを表現できるようになります。住所や部屋番号を言うより、お隣さんや近所の〇〇さんと言ってしまった方が簡単なのと同じです。

そのため多くのコマンドは、作業ディレクトリ上で操作を行うことを想定しています。たとえば、

```powershell
mkdir {ディレクトリ名}
```

のようなコマンドは、`{ディレクトリ名}`に一致するディレクトリを作業ディレクトリ内に作成します。

作業ディレクトリを変更するには、`cd`コマンドを使います。

```powershell
cd （ここにパスが入る）
```

作業ディレクトリの中身を見るには、`dir`コマンドを使います。

```powershell
dir
```

シェルの起動時には、多くの場合ホームディレクトリが作業ディレクトリとして指定してあります。ホームディレクトリは頻繁に用いるものなので、`~`という略称が与えられています。

```powershell
cd ~
```

でホームディレクトリに戻ることを確認しましょう。

#### Scoop を用いた環境構築（推奨）

**パッケージ管理ツール**と呼ばれる、ソフトウェアのインストールを簡単にするためのツールをインストールします。
[Chocolatey](https://chocolatey.org/) など他のパッケージ管理ツールもありますが、
[Scoop](https://scoop.sh/) を用いた環境構築を推奨します。

Scoop をインストールするには、PowerShell を**管理者権限**で起動し、以下のコマンドを入力します：

```powershell
iwr -useb get.scoop.sh | iex
```

インストールに失敗する際は、以下のコマンドを入力してから再度上のコマンドを入力してみましょう：

```powershell
Set-ExecutionPolicy RemoteSigned -scope CurrentUser
```

これらの操作を行うためには、ユーザーアカウントに[管理者権限](https://support.microsoft.com/ja-jp/windows/63267a09-9926-991a-1c77-d203160c8563)があることが前提となります。

#### Gitのインストール

Railway を進めるには、**Git**のインストールが必要です。管理者権限で起動した PowerShell に以下のコマンドを入力して、Scoop を経由してインストールしましょう(すでにGitをインストールしてある場合はスキップしてください)：

```powershell
scoop install git
```

#### 最後にこのリポジトリを自分のPC(ローカル環境)にダウンロード(Git Clone)します。

1. PowerShell を開きます
2. `git clone https://github.com/{{yourGitHubID}}/laravel-stations.git` で自分のPCにこのリポジトリをダウンロードします
3. `cd laravel-stations` でカレントディレクトリをダウンロードしたディレクトリである `laravel-stations` に移動します。
4. `cp .env.example .env` を実行して、 `.env` ファイルを作成します。
5. `docker compose build --no-cache` を実行します。

↓のような表示が流れていくことを確認してください

![d161a9cadf8e80bcaa66273d3f2ee10b](https://user-images.githubusercontent.com/16362021/149891105-ef42351e-006b-4985-95dc-a8c210ef19ea.gif)

6. `docker compose up -d` を実行します。
6. `docker compose exec php-container composer install` を実行します。
7. `docker compose ps` というコマンドを打って次のような表示になっていれば、ひとまずOKです！

![スクリーンショット 2022-05-23 11 16 39](https://user-images.githubusercontent.com/16362021/169730921-fc40f8af-b8df-4074-adad-cba13b4a2d48.png)

8. 3分ほど待ってから、 http://localhost:8888 を開いて次のような表示になっていることを確認してください。

![スクリーンショット 2022-03-18 16 09 00](https://user-images.githubusercontent.com/16362021/158953853-a4105a2c-b042-46af-83cf-e1737cd51912.png)

↑ここに至るまでに時間を待たずに http://localhost:8888 を開くとしばらく画面がエラーとなっている状態になります。
具体的には次のいずれか2つような画面です。その際には数分待ってからリロードしてみてください。

![スクリーンショット 2022-05-23 11 18 45](https://user-images.githubusercontent.com/16362021/169731216-395ab51b-85b1-4746-a825-63ae81c2a582.png)
![スクリーンショット 2022-05-23 11 19 44](https://user-images.githubusercontent.com/16362021/169731217-e27394e9-7f4a-46a2-b314-86c225194894.png)

# データベースの中身を確認したい場合

1. http://localhost:58080/ にアクセスする
2. 次の情報を入力し、「ログイン」ボタンをクリックする

 - サーバ: mysql-container
 - ユーザー名: dev
 - パスワード: dev
 - データベース: laravel_stations

# エラーログの確認先

storage/logs/laravel.logを確認してください。
