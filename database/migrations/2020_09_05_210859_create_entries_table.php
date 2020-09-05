<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entries', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->dateTime('datetime')->comment('日時');
            $table->string('title')->comment('タイトル');
            $table->text('body')->comment('本文');
            $table->bigInteger('user_id', false, true);
            $table->timestamps();
            $table->softDeletes();
        });
        DB::statement('ALTER TABLE entries COMMENT \'記事\'');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entries');
    }
}
