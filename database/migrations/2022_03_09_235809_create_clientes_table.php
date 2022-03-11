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
            $table->string('type');
            $table->string('name');
            $table->string('location');
            $table->string('email');
            $table->string('bio');
            $table->string('twitter_username');
            $table->string('public_repos');
            $table->string('followers');
            $table->string('following');

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
