<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPhoneNumberColumnToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table =config('passauth.user.table.name');
        $phone_number_enabled = config('passauth.required_identifiants.phone_number');

        if ($phone_number_enabled) {
            Schema::table($table, function (Blueprint $table) {
                if (!phone_number_column_exists_in_schema()) {
                    $table->string('phone_number') ->nullable() ->after('email');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $table =config('passauth.user.table.name');

        Schema::table($table, function (Blueprint $table) {
            if (phone_number_column_exists_in_schema()) {
                $table ->dropColumn('phone_number');
            }
        });
    }
}
