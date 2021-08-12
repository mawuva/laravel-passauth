<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHasAgreedWithPolicyAndTermsAtColumnToUsersTable extends Migration
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
        $agree_with_policy_and_terms_column_type = config('passauth.agree_with_policy_and_terms_column.type');

        Schema::table($table, function (Blueprint $table)
        use($agree_with_policy_and_terms_column_name,  $agree_with_policy_and_terms_column_type) {
            if (!agree_with_policy_and_terms_is_enabled_and_exists()) {
                $table  ->{$agree_with_policy_and_terms_column_type}($agree_with_policy_and_terms_column_name) 
                        ->nullable() ->after('password');
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
        $agree_with_policy_and_terms_column_name = config('passauth.agree_with_policy_and_terms_column.name');

        Schema::table($table, function (Blueprint $table)
        use($agree_with_policy_and_terms_column_name) {
            if (agree_with_policy_and_terms_is_enabled_and_exists()) {
                $table ->dropColumn($agree_with_policy_and_terms_column_name);
            }
        });
    }
}
