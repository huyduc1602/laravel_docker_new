<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dtb_news', function (Blueprint $table) {
            $table->increments('id')->comment('ID');
            $table->string('title', 50)->comment('タイトル');
            $table->string('information', 400)->comment('お知らせ');
            $table->string('url', 200)->comment('URL')->nullable();
            $table->tinyInteger('login_display_flg')->comment('ログイン表示フラグ')->default(1);
            $table->tinyInteger('home_display_flg')->comment('ホーム表示フラグ')->nullable();
            $table->date('release_date')->comment('公開開始日');
            $table->time('release_time')->comment('公開開始時刻')->nullable();
            $table->date('end_date')->comment('公開終了日')->nullable();
            $table->time('end_time')->comment('公開終了時刻')->nullable();
            $table->date('record_date')->comment('登録日')->nullable();
            $table->time('record_time')->comment('登録時刻')->nullable();
            $table->string('registrant', 50)->comment('登録者')->nullable();
            $table->string('download_key', 200)->comment('ダウンロードキー')->nullable();
            $table->string('file_path', 200)->comment('ファイルパス')->nullable();
            $table->string('file_name', 200)->comment('ファイル名')->nullable();
            $table->tinyInteger('del_flg')->default(0)->comment('削除フラグ');
            $table->tinyInteger('version')->default(1)->comment('バージョン');
            $table->datetime('create_datetime')->comment('作成日時')->nullable();
            $table->string('create_function', 10)->comment('作成機能ID')->nullable();
            $table->string('create_user', 255)->comment('作成者ID')->nullable();
            $table->string('create_name', 50)->comment('作成者')->nullable();
            $table->datetime('update_datetime')->comment('更新日時')->nullable();
            $table->string('update_function', 10)->comment('更新機能ID')->nullable();
            $table->string('update_user', 255)->comment('更新者ID')->nullable();
            $table->string('update_name', 50)->comment('更新者')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dtb_news');
    }
};
