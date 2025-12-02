<?php

    use Illuminate\Support\Facades\Log;
    use Illuminate\Support\Facades\Crypt;


    // Meta data
    /**
     * Set meta data for a page
     */
    if (! function_exists('vlxSetPageMeta')) {
        function vlxSetPageMeta($custom = null) {
            global $site;
            if ($custom) {
                echo "<meta name='description' content='$custom'>";
            } else {
                echo "<meta name='description' content='". env("APP_DESCRIPTION") ."'>";
            }
            echo '
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <meta http-equiv="X-UA-Compatible" content="ie=edge">
            ';
        }
    }
    /**
     * Set meta data for a page that is used by socials
     */
    if (! function_exists('vlxSetSocialMeta')) {
        function vlxSetSocialMeta() {
            echo '
                <meta property="og:title" content="' . env("APP_NAME") . '">
                <meta property="og:description" content="'. env("APP_DESCRIPTION") .'">
                <meta property="og:image" content="'. env("APP_URL") .'">
                <meta property="og:url" content="'. env("APP_URL") .'">

                <meta name="twitter:title" content="Add title here">
                <meta name="twitter:description" content="'. env("APP_DESCRIPTION") .'">
                <meta name="twitter:image" content="'. env("APP_URL") .'">
                <meta name="twitter:url" content="'. env("APP_URL") .'">
            ';
        }
    }




    // Checking
    /**
     * Check if a string is encrypted
     */
    if (! function_exists('vlxIsEncrypted')) {
        function vlxIsEncrypted($string) {
            // check if the string is encrypted with the laravel Crypt
            try {
                $decrypted = decrypt($string);
                return true;
            } catch (\Exception $e) {
                return false;
            }
        }
    }

    if (! function_exists('vlxEncrypt')) {
        function vlxEncrypt($string) {
            return Crypt::encrypt($string);
        }
    }

    if (! function_exists('vlxDecrypt')) {
        function vlxDecrypt($string) {
            return Crypt::decrypt($string);
        }
    }




    // Format
    /**
     * Format a string (remove underscores and semicolons)
     */
    if (! function_exists('vlxFormat')) {
        function vlxFormat($string) {

            if(str_contains($string, '_')) { $string = str_replace('_', ' ', $string); }
            if(str_contains($string, ';')) { $string = str_replace(';', '', $string); }

            return $string;

        }
    }

    /**
     * Format a number
     */
    if (! function_exists('vlxNumberFormat')) {
        function vlxNumberFormat($input, $decimals){
            return number_format($input, $decimals, '.', ',');
        }
    }




    // Make something from something
    /**
     * Slugify a string
     */
    if (! function_exists('vlxSlugify')) {
        function vlxSlugify($string) {
            return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string), '-'));
        }
    }

    /**
     * Emailfy a name
     */
    if (! function_exists('vlxEmailfy')) {
        function vlxEmailfy($name) {

            $email = strtolower($name);
            $email = str_replace('.', '', $email);
            $email = str_replace(' ', '.', $email);
            $email = $email . '@' . vlxGetAppDomain();

            return $email;

        }
    }

    /**
     * Cast an array to an object
     */
    if (! function_exists('vlxCastToObject')) {
        function vlxCastToObject($array) {
            if (is_array($array)) {
                return (object) array_map(__FUNCTION__, $array);
            } else {
                return $array;
            }
        }
    }

    /**
     * Cast an object to an array
     */
    if (! function_exists('vlxCastToArray')) {
        function vlxCastToArray($object) {
            if (is_object($object)) {
                $object = (array) $object;
                return array_map(__FUNCTION__, $object);
            } else {
                return $object;
            }
        }
    }

    /**
     * Replace placeholders in a string
     */
    if (! function_exists('vlxReplacePlaceholders')) {
        function vlxReplacePlaceholders($string) {

            if (str_contains($string, '%APP_NAME%')) $string = str_replace('%APP_NAME%', env('APP_NAME'), $string);
            if (str_contains($string, '%APP_URL%')) $string = str_replace('%APP_URL%', env('APP_URL'), $string);
            if (str_contains($string, '%APP_DESCRIPTION%')) $string = str_replace('%APP_DESCRIPTION%', env('APP_DESCRIPTION'), $string);
            if (str_contains($string, '%APP_DOMAIN%')) $string = str_replace('%APP_DOMAIN%', vlxGetAppDomain(), $string);


            return $string;
        }
    }




    // Slashes
    /**
     * Add a slash at the start of a string
     */
    if (! function_exists('vlxStartSlashIt')) {
        function vlxStartSlashIt($string) {

            $string = trim($string, '/');
            $string = '/' . $string;

            return preg_replace('#/+#', '/', $string);

        }
    }

    /**
     * Add a slash at the end of a string
     */
    if (!function_exists('vlxEndSlashIt')) {
        function vlxEndSlashIt($string) {

            Log::debug($string);

            $string = rtrim($string, '/');
            $string .= '/';

            Log::debug($string);

            return preg_replace('#/+#', '/', $string);

        }
    }




    // Route urls
    /**
     * Get the account url
     */
    if (! function_exists('vlxGetAccountUrl')) {
        function vlxGetAccountUrl() {

            $url = !empty(env('SETTING_ACCOUNT_URL')) ? env('SETTING_ACCOUNT_URL') : 'account';
            return vlxStartSlashIt($url);

        }
    }

    /**
     * Get the admin url
     */
    if (! function_exists('vlxGetAdminUrl')) {
        function vlxGetAdminUrl() {

            $url = !empty(env('SETTING_ADMIN_URL')) ? env('SETTING_ADMIN_URL') : 'admin';
            return vlxStartSlashIt($url);

        }
    }

    /**
     * Get the auth url
     */
    if (! function_exists('vlxGetAuthUrl')) {
        function vlxGetAuthUrl() {

            $url = !empty(env('SETTING_AUTH_URL')) ? env('SETTING_AUTH_URL') : 'auth';
            return vlxStartSlashIt($url);

        }
    }




    // Get paths
    /**
     * Get the path to something
     */
    if (! function_exists('vlxPathToSomething')) {
        function vlxPathToSomething() {

            /* $path = env('');
            return $path; */

        }
    }




    // App domain
    /**
     * Get the domain of the app
     */
    if (! function_exists('vlxGetAppDomain')) {
        function vlxGetAppDomain() {

            $domain = env('APP_DOMAIN');
            $domain = str_replace(['http:', 'https:', '/'], '', $domain);

            return $domain;

        }
    }




    // Get shit from env
    /**
     * Get a string from the ENV file (unless it contains a "KEY", "API", "USERNAME", "PASS")
     */
    if (! function_exists('vlxGetEnvString')) {
        function vlxGetEnvString($env_key) {

            //if(str_contains($env_key, 'KEY')) return null;
            if(str_contains($env_key, 'API')) return null;
            //if(str_contains($env_key, 'USERNAME')) return null;
            //if(str_contains($env_key, 'PASS')) return null;

            $string = env($env_key);
            $string = vlxFormat($string);

            return $string;
        }
    }




    // Check if a string is an error
    /**
     * Check if string is error
     */
    if (! function_exists('vlxError')) {
        function vlxError($str) {
            if (is_string($str) && str_starts_with($str, 'error:')) {
                return true;
            }
            return false;
        }
    }


    // Check a users permissions
    if (!function_exists('vlxCheckPermission')) {
        /**
         * Check if the currently authenticated user has the given permissions
         *
         * @param array|string $permissions Single permission or array of permissions
         * @param bool $useResponse Whether to throw/return HTTP response or just return bool
         * @return bool|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
         */
        function vlxCheckPermission($permissions, bool $useResponse = false) {
            $controller = app(\App\Http\Controllers\Controller::class);

            // Ensure array
            $permissions = is_array($permissions) ? $permissions : [$permissions];

            return $controller->checkPermission($permissions, $useResponse);
        }
    } else {
        Log::warning('Function vlxCheckPermission already exists in helpers.php');
    }




    // UUID (DEPRECATED)
    /**
     * Create a UUID (Universally Unique Identifier)
     * @deprecated
     */
    if (! function_exists('vlx_make_uuid')) {
        function vlx_make_uuid() {
            // Generate 16 bytes (128 bits) of random data or use the data passed into the function.
            $data = random_bytes(16);
            assert(strlen($data) == 16);

            // Set version to 0100
            $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
            // Set bits 6-7 to 10
            $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

            // Output the 36 character UUID.
            return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
        }
    }

?>
