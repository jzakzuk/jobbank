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
        Schema::table('job_offer_has_users', function (Blueprint $table) {
            $table->foreign(['offer_id'], 'job_offer_has_users_ibfk_1')->references(['id'])->on('job_offers')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['user_id'], 'job_offer_has_users_ibfk_2')->references(['id'])->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('job_offer_has_users', function (Blueprint $table) {
            $table->dropForeign('job_offer_has_users_ibfk_1');
            $table->dropForeign('job_offer_has_users_ibfk_2');
        });
    }
};
