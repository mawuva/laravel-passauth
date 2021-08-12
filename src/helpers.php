<?php

use Faker\Factory;
use Illuminate\Support\Facades\Schema;

if ( ! function_exists('check_input_value')) {
    /**
     * Chef if a key exists in array
     *
     * @param array $array
     * @param string $key
     * 
     * @return string
     */
    function check_input_value(array $array = [], string $key = '') {
        if (is_array($array) && !empty($key)) {
            if (key_exists($key, $array)) {
                if ($array[$key] != null) {
                    return $array[$key];
                }
            }
        }
    }
}

if (!function_exists('all_identifiants_are_set_to_false')) {
    /**
     * Return resource's url
     * @return string
     */
    function all_identifiants_are_set_to_false() {
        foreach (config('passauth.required_identifiants') as $identifiant) {
            if ($identifiant === true) {
                return false;
            }
        }

        return true;
    }
}

if (!function_exists('email_is_defined_as_identifiant')) {
    /**
     * Check if email is defined as identifiant.
     * @return string
     */
    function email_is_defined_as_identifiant() {
        return (config('passauth.required_identifiants.email') || all_identifiants_are_set_to_false())
                ? true
                : false;
    }
}

if (!function_exists('phone_number_column_exists_in_schema')) {
    /**
     * Check if schema has phone number column.
     * 
     * @return bool
     */
    function phone_number_column_exists_in_schema(): bool {
        $table = config('passauth.user.table.name');

        return (Schema::hasColumn($table, 'phone_number'))
                ? true
                : false;
    }
}

if (!function_exists('phone_number_is_required_and_exists')) {
    /**
     * Check if phone number is enabled and exists in schema.
     * 
     * @return bool
     */
    function phone_number_is_required_and_exists(): bool {
        $phone_number_enabled = config('passauth.required_identifiants.phone_number');

        return ($phone_number_enabled && phone_number_column_exists_in_schema())
                ? true
                : false;
    }
}

if ( ! function_exists('define_random_username')) {
    /**
     * Generate username from random string
     *
     * @param int $min
     * @param int $max
     * 
     * @return string
     */
    function define_random_username(int $min = 3, int $max = 12, $rand_bytes = true): string {
        $faker = Factory::create();

        $str = '';
        $nbr = '';

        for ($i = 0; $i < rand($min, $max); $i++) {
            $str .= '?';
            $nbr .= '#';
        }

        return ($rand_bytes)
                ? $faker->bothify($str.'-'.$nbr) . '-' . bin2hex(random_bytes(rand($min, $max)))
                : $faker->bothify($str.$nbr);
    }
}

if (!function_exists('proper_names_columns_exists_in_schema')) {
    /**
     * Check if schema has proper names columns.
     * 
     * @return bool
     */
    function proper_names_columns_exists_in_schema(): bool {
        $table = config('passauth.user.table.name');

        return (Schema::hasColumn($table, 'last_name') && Schema::hasColumn($table, 'first_name'))
                ? true
                : false;
    }
}

if (!function_exists('proper_names_is_required_and_exists')) {
    /**
     * Check if proper names is enabled and exists in schema.
     * 
     * @return bool
     */
    function proper_names_is_required_and_exists(): bool {
        $proper_names_enabled = config('passauth.enable.proper_names');

        return ($proper_names_enabled && proper_names_columns_exists_in_schema())
                ? true
                : false;
    }
}

if (!function_exists('agree_with_policy_and_terms_is_enabled_and_exists')) {
    /**
     * Check if schema has agree with policy and terms column.
     * 
     * @return bool
     */
    function agree_with_policy_and_terms_is_enabled_and_exists(): bool {
        $table = config('passauth.user.table.name');
        $agree_with_policy_and_terms_enabled = config('passauth.enable.agree_with_policy_and_terms_data');
        $agree_with_policy_and_terms_column_name = config('passauth.agree_with_policy_and_terms_column.name');

        return ($agree_with_policy_and_terms_enabled && Schema::hasColumn($table, $agree_with_policy_and_terms_column_name))
                ? true
                : false;
    }
}

if (!function_exists('last_login_is_enabled_and_exists')) {
    /**
     * Check if last login is enabled and exists in schema.
     * 
     * @return bool
     */
    function last_login_is_enabled_and_exists(): bool {
        $table = config('passauth.user.table.name');
        $last_login_enabled = config('passauth.enable.last_login_data');
        $last_login_column_name = config('passauth.last_login_column.name');

        return ($last_login_enabled && Schema::hasColumn($table, $last_login_column_name))
                ? true
                : false;
    }
}
