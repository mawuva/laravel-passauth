<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProperNamesAttributesToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table = config('passauth.user.table.name');

        if (proper_names_is_required_and_does_not_exist()) {
            Schema::table($table, function (Blueprint $table) {
                $table->string('last_name') ->nullable() ->after('name');
                $table->string('first_name') ->nullable() ->after('last_name');
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
            if (proper_names_columns_exists_in_schema()) {
                $table ->dropColumn('last_name');
                $table ->dropColumn('first_name');
            }
        });
    }
}
