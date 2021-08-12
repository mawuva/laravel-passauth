<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLastLoginAtColumnToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table = config('passauth.user.table.name');

        $agree_with_policy_and_terms_column_name = config('passauth.agree_with_policy_and_terms_column.name');

        $last_login_column_name = config('passauth.last_login_column.name');
        $last_login_column_type = config('passauth.last_login_column.type');

        Schema::table($table, function (Blueprint $table)
        use($last_login_column_name, $last_login_column_type, $agree_with_policy_and_terms_column_name) {
            if (!last_login_is_enabled_and_exists()) {
                (agree_with_policy_and_terms_is_enabled_and_exists())
                    ? $table->{$last_login_column_type}($last_login_column_name) ->nullable() ->after($agree_with_policy_and_terms_column_name)
                    : $table->{$last_login_column_type}($last_login_column_name) ->nullable() ->after('password');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $table = config('passauth.user.table.name');
        $last_login_column_name = config('passauth.last_login_column.name');

        Schema::table($table, function (Blueprint $table)
        use ($last_login_column_name){
            if (last_login_is_enabled_and_exists()) {
                $table->dropColumn($last_login_column_name);
            }
        });
    }
}
