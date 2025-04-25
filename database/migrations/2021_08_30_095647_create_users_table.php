<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->string('phone_number')->nullable();
            $table->string('profile_pic')->nullable();
            $table->unsignedBigInteger('gender_id')->nullable();
            $table->unsignedBigInteger('status_id')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('gender_id')->references('id')->on('genders')
                ->onDelete('cascade');
            $table->foreign('status_id')->references('id')->on('statuses')
                ->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('companies')
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
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['gender_id']);
            $table->dropForeign(['status_id']);
            $table->dropForeign(['company_id']);
            $table->dropColumn(['gender_id', 'status_id', 'company_id']);
            $table->dropIfExists();
        });

    }
}
