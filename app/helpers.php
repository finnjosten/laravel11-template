<?php




    // Meta data
    /**
     * Set meta data for a page
     */

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Crypt;

    if (! function_exists('vlx_set_page_meta')) {
        function vlx_set_page_meta($custom = null) {
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
    if (! function_exists('vlx_set_social_meta')) {
        function vlx_set_social_meta() {
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
    if (! function_exists('vlx_format')) {
        function vlx_format($string) {

            if(str_contains($string, '_')) { $string = str_replace('_', ' ', $string); }
            if(str_contains($string, ';')) { $string = str_replace(';', '', $string); }

            return $string;

        }
    }

    /**
     * Format a number
     */
    if (! function_exists('vlx_number_format')) {
        function vlx_number_format($input, $decimals){
            return number_format($input, $decimals, '.', ',');
        }
    }

    /**
     * Format a route name
     */
    if (! function_exists('vlx_format_route_name')) {
        function vlx_format_route_name($string) {

            $string = explode('.', $string)[0];
            $string = str_replace('-', ' ', $string);
            $string = ucwords($string);

            return $string;

        }
    }




    // Make something from something
    /**
     * Slugify a string
     */
    if (! function_exists('vlx_slugify')) {
        function vlx_slugify($string) {
            return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string), '-'));
        }
    }

    /**
     * Emailfy a name
     */
    if (! function_exists('vlx_emailfy')) {
        function vlx_emailfy($name) {

            $email = strtolower($name);
            $email = str_replace('.', '', $email);
            $email = str_replace(' ', '.', $email);
            $email = $email . '@' . vlx_get_app_domain();

            return $email;

        }
    }

    /**
     * Get propper uptime back
     */
    if (! function_exists('vlx_get_uptime')) {
        function vlx_get_uptime($uptime) {

            $days = explode(' ', $uptime)[3];
            $hours_and_min = explode(' ', $uptime)[6];

            if (isset($days)) {

                if ($days == 0) {
                    $days = '';
                } else {
                    $days = $days . 'd';
                }
            }
            if (isset($hours_and_min)) {
                $hours_and_min = trim($hours_and_min, ',');
                $hours = explode(':', $hours_and_min)[0];
                $min = explode(':', $hours_and_min)[1];

                if ($hours == 0) {
                    $hours = '';
                } else {
                    $hours = $hours . 'h';
                }

                if ($min == 0) {
                    $min = '';
                } else {
                    $min = $min . 'm';
                }

            }

            return $days . ' ' . $hours . ' ' . $min;
        }
    }

    /**
     * Cast an array to an object
     */
    if (! function_exists('vlx_cast_to_object')) {
        function vlx_cast_to_object($array) {
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
    if (! function_exists('vlx_cast_to_array')) {
        function vlx_cast_to_array($object) {
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
    if (! function_exists('vlx_replace_placeholders')) {
        function vlx_replace_placeholders($string) {

            if (str_contains($string, '%APP_NAME%')) $string = str_replace('%APP_NAME%', env('APP_NAME'), $string);
            if (str_contains($string, '%APP_URL%')) $string = str_replace('%APP_URL%', env('APP_URL'), $string);
            if (str_contains($string, '%APP_DESCRIPTION%')) $string = str_replace('%APP_DESCRIPTION%', env('APP_DESCRIPTION'), $string);
            if (str_contains($string, '%APP_DOMAIN%')) $string = str_replace('%APP_DOMAIN%', vlx_get_app_domain(), $string);


            return $string;
        }
    }




    // Slashes
    /**
     * Add a slash at the start of a string
     */
    if (! function_exists('vlx_start_slash_it')) {
        function vlx_start_slash_it($string) {

            $string = trim($string, '/');
            $string = '/' . $string;

            return preg_replace('#/+#', '/', $string);

        }
    }

    /**
     * Add a slash at the end of a string
     */
    if (!function_exists('vlx_end_slash_it')) {
        function vlx_end_slash_it($string) {

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
    if (! function_exists('vlx_get_account_url')) {
        function vlx_get_account_url() {

            $url = !empty(env('SETTING_ACCOUNT_URL')) ? env('SETTING_ACCOUNT_URL') : 'account';
            return vlx_start_slash_it($url);

        }
    }

    /**
     * Get the admin url
     */
    if (! function_exists('vlx_get_admin_url')) {
        function vlx_get_admin_url() {

            $url = !empty(env('SETTING_ADMIN_URL')) ? env('SETTING_ADMIN_URL') : 'admin';
            return vlx_start_slash_it($url);

        }
    }

    /**
     * Get the auth url
     */
    if (! function_exists('vlx_get_auth_url')) {
        function vlx_get_auth_url() {

            $url = !empty(env('SETTING_AUTH_URL')) ? env('SETTING_AUTH_URL') : 'auth';
            return vlx_start_slash_it($url);

        }
    }




    // Get paths
    /**
     * Get the path to something
     */
    if (! function_exists('vlx_path_to_something')) {
        function vlx_path_to_something() {

            /* $path = env('');
            return $path; */

        }
    }




    // App domain
    /**
     * Get the domain of the app
     */
    if (! function_exists('vlx_get_app_domain')) {
        function vlx_get_app_domain() {

            $domain = env('APP_DOMAIN');
            $domain = str_replace(['http:', 'https:', '/'], '', $domain);

            return $domain;

        }
    }




    // Get shit from env
    /**
     * Get a string from the ENV file (unless it contains a "KEY", "API", "USERNAME", "PASS")
     */
    if (! function_exists('vlx_get_env_string')) {
        function vlx_get_env_string($env_key) {

            //if(str_contains($env_key, 'KEY')) return null;
            if(str_contains($env_key, 'API')) return null;
            //if(str_contains($env_key, 'USERNAME')) return null;
            //if(str_contains($env_key, 'PASS')) return null;

            $string = env($env_key);
            $string = vlx_format($string);

            return $string;
        }
    }




    // Check if a string is an error
    /**
     * Check if string is error
     */
    if (! function_exists('vlx_error')) {
        function vlx_error($str) {
            if (is_string($str) && str_starts_with($str, 'error:')) {
                return true;
            }
            return false;
        }
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
