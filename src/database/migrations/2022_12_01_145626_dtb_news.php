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
        Schema::create('dtb_news', function (Blueprint $table) {
            $table->increments('id')->comment('ID');			
            $table->string('title',50)->comment('タイトル');			
            $table->string('information',400)->comment('お知らせ');		
            $table->string('url',200)->comment('URL');			
            $table->tinyInteger('login_display_flg')->comment('ログイン表示フラグ');		
            $table->tinyInteger('home_display_flg')->comment('ホーム表示フラグ');			
            $table->date('release_date')->comment('公開開始日');			
            $table->time('release_time')->comment('公開開始時刻');			
            $table->date('end_date')->comment('公開終了日');			
            $table->time('end_time')->comment('公開終了時刻');			
            $table->date('record_date')->comment('登録日');			
            $table->time('record_time')->comment('登録時刻');			
            $table->string('registrant',50)->comment('登録者');			
            $table->string('download_key',200)->comment('ダウンロードキー');			
            $table->string('file_path',200)->comment('ファイルパス');			
            $table->string('file_name',200)->comment('ファイル名');			
            $table->tinyInteger('del_flg')->default(0)->comment('削除フラグ');			
            $table->tinyInteger('version')->default(1)->comment('バージョン');			
            $table->datetime('create_datetime')->comment('作成日時');			
            $table->string('create_function',10)->comment('作成機能ID');			
            $table->string('create_user',255)->comment('作成者ID');			
            $table->string('create_name',50)->comment('作成者');			
            $table->datetime('update_datetime')->comment('更新日時');			
            $table->string('update_function',10)->comment('更新機能ID');			
            $table->string('update_user',255)->comment('更新者ID');			
            $table->string('update_name',50)->comment('更新者');	 
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
