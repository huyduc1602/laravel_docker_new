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
        Schema::create('mst_user', function (Blueprint $table) {
            $table->increments('id')->comment('ID');
            $table->string('user_name', 50)->comment('ユーザー名')->nullable();
            $table->tinyInteger('user_auth')->comment('ユーザー権限')->nullable();
            $table->string('email', 255)->comment('メールアドレス');
            $table->string('password', 255)->comment('パスワード');
            $table->datetime('update_pass_date')->comment('パスワード更新日')->nullable();
            $table->tinyInteger('update_pass_flg')->default(0)->comment('パスワード更新フラグ')->nullable();
            $table->string('memo', 200)->comment('備考')->nullable();
            $table->tinyInteger('del_flg')->default(0)->comment('削除フラグ');
            $table->integer('version')->default(1)->comment('バージョン');
            $table->datetime('create_date')->comment('作成日時')->nullable();
            $table->string('create_function', 10)->comment('作成機能ID')->nullable();
            $table->string('create_user', 255)->comment('作成者ID')->nullable();
            $table->string('create_name', 50)->comment('作成者')->nullable();
            $table->datetime('update_date')->comment('更新日時')->nullable();
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
        Schema::dropIfExists('mst_user');
    }
};
