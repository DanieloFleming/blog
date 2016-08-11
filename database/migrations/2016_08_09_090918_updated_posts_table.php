<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatedPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function(Blueprint $table){
            $table->string('slug', 200)->after('title')->unique()->nullable();
            $table->dateTime('published_at')->default(date("Y-m-d H:i:s"))->after('content');
            $table->enum('type', ['published', 'draft', 'autoSaved'])->default('draft')->after('published_at');
            $table->integer('post_id')->nullable()->after('post_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function(Blueprint $table){
            $table->dropColumn(['slug', 'published_at', 'type', 'post_id']);
        });
    }
}
