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
            $table->integer('id',11)->increments()->primary()->comment('ID');			
            $table->string('title',50)->comment('タイトル');			
            $table->string('information',400)->comment('お知らせ');		
            $table->string('url',200)->comment('URL');			
            $table->integer('login_display_flg',1)->comment('ログイン表示フラグ');		
            $table->integer('home_display_flg',1)->comment('ホーム表示フラグ');			
            $table->date('release_date date')->comment('公開開始日');			
            $table->time('release_time time')->comment('公開開始時刻');			
            $table->date('end_date date')->comment('公開終了日');			
            $table->time('end_time time')->comment('公開終了時刻');			
            $table->date('record_date date')->comment('登録日');			
            $table->time('record_time time')->comment('登録時刻');			
            $table->string('registrant',50)->comment('登録者');			
            $table->string('download_key',200)->comment('ダウンロードキー');			
            $table->string('file_path',200)->comment('ファイルパス');			
            $table->string('file_name',200)->comment('ファイル名');			
            $table->integer('del_flg',1)->default(0)->comment('削除フラグ');			
            $table->integer('version',11)->default(1)->comment('バージョン');			
            $table->datetime('create_date datetime')->comment('作成日時');			
            $table->string('create_function',10)->comment('作成機能ID');			
            $table->integer('create_user',11)->comment('作成者ID');			
            $table->string('create_name',50)->comment('作成者');			
            $table->datetime('update_date datetime')->comment('更新日時');			
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
