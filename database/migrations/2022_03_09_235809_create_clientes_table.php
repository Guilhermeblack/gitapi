<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            
            $table->id();
            $table->bigInteger('usr_id')->unsigned();
            $table->string('login');
            $table->string('id_git');
            $table->string('node_id');
            $table->string('avatar_url');
            $table->string('gravatar_id');
            $table->string('url');
            $table->string('html_url');
            $table->string('followers_url');
            $table->string('following_url');
            $table->string('gists_url');
            $table->string('starred_url');
            $table->string('subscriptions_url');
            $table->string('organizations_url');
            $table->string('repos_url');
            $table->string('events_url');
            $table->string('received_events_url');
            $table->string('type');
            $table->string('name');
            $table->string('location');
            $table->string('email');
            $table->boolean('site_admin');
            $table->string('bio');
            $table->string('company');
            $table->string('hireable');
            $table->string('blog');
            $table->string('twitter_username');
            $table->string('public_repos');
            $table->string('public_gists');
            $table->string('followers');
            $table->string('following');

            $table->timestamp('deleted_at')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();


            $table->foreign('usr_id')
            ->references('id')->on('users')
            ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}
