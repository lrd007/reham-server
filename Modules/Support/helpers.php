<?php

use BeaBee\BeaBee;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cookie;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Support\RTLDetector;

if (!function_exists('str_between')) {
    /**
     * Get the portion of a string between the given values.
     *
     * @param string $subject
     * @param string $search
     * @return string
     */
    function str_between($subject, $startsWith, $endsWith)
    {
        return str_after(str_before($subject, $endsWith), $startsWith);
    }
}

if (!function_exists('locale')) {
    /**
     * Get current locale.
     *
     * @return string
     */
    function locale()
    {
        return app()->getLocale();
    }
}

if (!function_exists('is_rtl')) {
    /**
     * Determine if the given / current locale is RTL script.
     *
     * @param string|null $locale
     * @return bool
     */
    function is_rtl($locale = null)
    {
        return RTLDetector::detect($locale ?: locale());
    }
}

if (!function_exists('currency')) {
    /**
     * Get current currency.
     *
     * @return string
     */
    function currency()
    {
        if (app('inAdminPanel')) {
            return setting('default_currency');
        }

        $currency = Cookie::get('currency');

        if (!in_array($currency, setting('supported_currencies'))) {
            $currency = setting('default_currency');
        }

        return $currency;
    }
}

if (!function_exists('supported_locales')) {
    /**
     * Get all supported locales.
     *
     * @return array
     */
    function supported_locales()
    {
        return LaravelLocalization::getSupportedLocales();
    }
}

if (!function_exists('supported_locale_keys')) {
    /**
     * Get all supported locale keys.
     *
     * @return array
     */
    function supported_locale_keys()
    {
        return LaravelLocalization::getSupportedLanguagesKeys();
    }
}

if (!function_exists('localized_url')) {
    /**
     * Returns an URL adapted to the given locale.
     *
     * @param string $locale
     * @param string $url
     * @return string
     */
    function localized_url($locale, $url = null)
    {
        return LaravelLocalization::getLocalizedURL($locale, $url);
    }
}

if (!function_exists('non_localized_url')) {
    /**
     * It returns an URL without locale.
     *
     * @param string $url
     * @return string
     */
    function non_localized_url($url = null)
    {
        return LaravelLocalization::getNonLocalizedURL($url);
    }
}

if (!function_exists('is_multilingual')) {
    /**
     * Determine if the app has multi language.
     *
     * @return bool
     */
    function is_multilingual()
    {
        return count(supported_locales()) > 1;
    }
}

if (!function_exists('is_multi_currency')) {
    /**
     * Determine if the app has multi currency.
     *
     * @return bool
     */
    function is_multi_currency()
    {
        return count(setting('supported_currencies')) > 1;
    }
}

if (!function_exists('is_module_enabled')) {
    /**
     * Determine if the given module is enabled.
     *
     * @param string $module
     * @return bool
     */
    function is_module_enabled($module)
    {
        return array_key_exists($module, app('modules')->allEnabled());
    }
}

if (!function_exists('slugify')) {
    /**
     * Generate a URL friendly "slug" from a given string
     *
     * @param string $value
     */
    function slugify($value)
    {
        $slug = preg_replace('/[\s<>[\]{}|\\^%&\$,\/:;=?@#\'\"]/', '-', mb_strtolower($value));

        // Remove duplicate separators.
        $slug = preg_replace('/-+/', '-', $slug);

        // Trim special characters from the beginning and end of the slug.
        return trim($slug, '!"#$%&\'()*+,-./:;<=>?@[]^_`{|}~');
    }
}

if (!function_exists('v')) {
    /**
     * Version a relative asset using the time its contents last changed.
     *
     * @param string $value
     * @return string
     */
    function v($path)
    {
        if (config('app.env') === 'local') {
            $version = uniqid();
        } else {
            $version = BeaBee::VERSION;
        }

        return "{$path}?v=" . $version;
    }
}

if (!function_exists('beabee_version')) {
    /**
     * Get the fleetcart version.
     *
     * @return string
     */
    function beabee_version()
    {
        return BeaBee::VERSION;
    }
}

if (!function_exists('old_json')) {
    /**
     * Retrieve and json encode an old input item.
     *
     * @param string $array
     * @param mixed $default
     * @param mixed $options
     * @return string
     */
    function old_json($key, $default = [], $options = null)
    {
        $old = array_reset_index(old($key, []));

        return json_encode($old ?: $default, $options);
    }
}

if (!function_exists('array_reset_index')) {
    /**
     * Reset numeric index of an array recursively.
     *
     * @param array $array
     * @return array|\Illuminate\Support\Collection
     *
     * @see https://stackoverflow.com/a/12399408/5736257
     */
    function array_reset_index($array)
    {
        $array = $array instanceof Collection
        ? $array->toArray()
        : $array;

        foreach ($array as $key => $val) {
            if (is_array($val)) {
                $array[$key] = array_reset_index($val);
            }
        }

        if (isset($key) && is_numeric($key)) {
            return array_values($array);
        }

        return $array;
    }
}

if (!function_exists('html_attrs')) {
    /**
     * Convert array to html attributes.
     *
     * @param array $attributes
     * @return string
     */
    function html_attrs(array $attributes)
    {
        $string = '';

        foreach ($attributes as $name => $value) {
            $string .= " {$name}={$value}";
        }

        return $string;
    }
}

if (!function_exists('remove_file')) {

    function remove_file($path)
    {
        return file_exists($path) && is_file($path) ? @unlink($path) : false;
    }
}

if (!function_exists('upload_image')) {
    /**
     * Upload image and unlink existing image
     *
     * @param object|array $file
     * @param string $path
     * @param string $prefix
     * @return string
     */
    function upload_image($file, $path, $prefix = null)
    {
        $thumbnail = Image::make($file);

        if (is_null($prefix)) {
            $filename = time() . '.' . $file->getClientOriginalExtension();
        } else {
            $filename = $prefix . time() . '.' . $file->getClientOriginalExtension();
        }

        if (!is_dir($path)) {
            mkdir($path, 0755, true);
        }

        $file->move($path, $filename);
        $thumbnail->save($path . $filename);

        return $filename;
    }
}

if (!function_exists('upload_file')) {
    /**
     * Upload file
     *
     * @param object|array $file
     * @param string $path
     * @param string $prefix
     * @param string $filename
     * @return string
     */
    function upload_file($file, $path, $prefix = null, $filename = null)
    {
        if (is_null($prefix)) {
            $pdf = Str::random() . $filename . '.' . $file->getClientOriginalExtension();
        } else {
            $pdf = $prefix . time() . '.' . $file->getClientOriginalExtension();
        }

        if (!is_dir($path)) {
            mkdir($path, 0755, true);
        }

        $file->move($path, $pdf);

        return $pdf;
    }
}

if (!function_exists('assets_images')) {
    /**
     * Get asset images path
     *
     * @param string $folder
     * @return string
     */
    function assets_images($folder = null, $value = null)
    {
        if (!is_null($folder) && !is_null($value)) {
            return public_path('/assets/images/' . $folder . '/' . $value);
        } elseif (is_null($folder) && !is_null($value)) {
            return public_path('/assets/images/' . $value);
        } elseif (!is_null($folder) && is_null($value)) {
            return public_path('/assets/images/' . $folder . '/');
        } else {
            return public_path('/assets/images/');
        }
    }
}

if (!function_exists('assets_css')) {
    /**
     * Get asset css path
     *
     * @param string $value
     * @return string
     */
    function assets_css($value = null)
    {
        if (!is_null($value)) {
            return public_path('/assets/css/' . $value);
        } else {
            return public_path('/assets/css/');
        }
    }
}

if (!function_exists('assets_files')) {
    /**
     * Get asset files path
     *
     * @param string $value
     * @return string
     */
    function assets_files($folder = null, $value = null)
    {
        if (!is_null($folder) && !is_null($value)) {
            return public_path('/assets/files/' . $folder . '/' . $value);
        } elseif (is_null($folder) && !is_null($value)) {
            return public_path('/assets/files/' . $value);
        } elseif (!is_null($folder) && is_null($value)) {
            return public_path('/assets/files/' . $folder . '/');
        } else {
            return public_path('/assets/files/');
        }
    }
}

if (!function_exists('uploads_files')) {
    /**
     * Get uploads files path
     *
     * @param string $value
     * @return string
     */
    function uploads_files($folder = null, $value = null, $url = false)
    {
        $path = '';

        if (!is_null($folder) && !is_null($value)) {
            $path = '/uploads/files/' . $folder . '/' . $value;
        } elseif (is_null($folder) && !is_null($value)) {
            $path = '/uploads/files/' . $value;
        } elseif (!is_null($folder) && is_null($value)) {
            $path = '/uploads/files/' . $folder . '/';
        } else {
            $path = '/uploads/files/';
        }

        return $url ? url($path) : public_path($path);
    }
}

if (!function_exists('uploads_images')) {
    /**
     * Get uploads images path
     *
     * @param string $value
     * @return string
     */
    function uploads_images($folder = null, $value = null, $url = false)
    {
        $path = '';

        if (!is_null($folder) && !is_null($value)) {
            $path = '/uploads/images/' . $folder . '/' . $value;
        } elseif (is_null($folder) && !is_null($value)) {
            $path = '/uploads/images/' . $value;
        } elseif (!is_null($folder) && is_null($value)) {
            $path = '/uploads/images/' . $folder . '/';
        } else {
            $path = '/uploads/images/';
        }

        return $url ? url($path) : public_path($path);
    }
}

if (!function_exists('ref')) {
    function ref($num)
    {
        switch ($num) {
            case $num < 10:
                return "000" . $num;
                break;
            case $num >= 10 && $num < 100:
                return "00" . $num;
                break;
            case $num > +10 && $num >= 100 && $num < 1000:
                return "0" . $num;
                break;
            default:
                return $num;
        }
    }
}

if (!function_exists('is_valid_kw_civilid_checksum')) {
    function is_valid_kw_civilid_checksum($value)
    {
        $calculated = 0;
        $values = str_split($value);
        $weight = [2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2];

        for ($i = 0; $i <= 11; $i++) {
            $v = isset($values[$i]) ? $values[$i] : 0;
            $w = isset($weight[$i]) ? $weight[$i] : 0;
            $calculated += $v * $w;
        }

        $remainder = $calculated % 11;
        $checkdigit = 11 - $remainder;

        if ($checkdigit != (int) $values[11]) {
            return false;
        }

        return true;
    }
}
