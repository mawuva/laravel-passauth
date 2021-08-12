<?php

if (!function_exists('uuid_is_enabled_and_has_column')) {
    /**
     * Check if uuid is enabled and has column defined in config.
     * 
     * @return bool
     */
    function uuid_is_enabled_and_has_column(): bool {
        $uuid_enable    = config('passauth.uuids.enable');
        $uuid_column    = config('passauth.uuids.column');

        return ($uuid_enable && $uuid_column !== null)
                ? true
                : false;
    }
}

if (!function_exists('uuid_is_enabled_and_has_been_detected')) {
    /**
     * Check if uuid is enabled and has been detected.
     * 
     * @param string $resource
     * @param int|string $id
     * 
     * @return bool
     */
    function uuid_is_enabled_and_has_been_detected(string $resource, int|string $id = null, $inTrashed = false): bool {
        $model = config('passauth.'.$resource.'.model');
        $uuidColumn = config('passauth.uuids.column');

        return (config('passauth.uuids.enable') && is_the_given_id_a_uuid($uuidColumn, $id, $model, $inTrashed))
                ? true
                : false;
    }
}

if (!function_exists('resolve_key')) {
    /**
     * Get key to use to make queries
     * 
     * @param string $resource
     * @param int|string $id
     * 
     * @return string
     */
    function resolve_key(string $resource, int|string $id = null, $inTrashed = false): string {
        $uuidColumn = config('passauth.uuids.column');
        $resourcePrimaryKey = config('passauth.'.$resource.'.table.primary_key');

        return (uuid_is_enabled_and_has_been_detected($resource, $id, $inTrashed))
                ? $uuidColumn
                : $resourcePrimaryKey;
    }
}