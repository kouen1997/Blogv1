<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblBlogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_blog', function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->increments('id');
            $table->integer('user_id')->nullable()->unsigned();
            $table->foreign('user_id')->references('id')->on('tbl_users')->onDelete('cascade');
            $table->string('title')->nullable();
            $table->text('content')->nullable();
            $table->text('image')->nullable();
            $table->enum('category', ['BLOG', 'NEWS', 'TECHNOLOGY', 'LIFESTYLE', 'LIVELYHOOD']);
            $table->integer('views')->default(0);
            $table->string('slug')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_blog');
    }
}
