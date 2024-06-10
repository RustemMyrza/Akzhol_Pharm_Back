<?php

if (!function_exists('phoneFormat')) {
    function phoneFormat(string $phone): string
    {
        return rtrim(mb_substr($phone, 2));
    }
}

if (!function_exists('priceFormat')) {
    function priceFormat(string $price): string
    {
        return number_format($price, 0, '', ' ') . '₸';
    }
}

if (!function_exists('discountFormat')) {
    function discountFormat(int $discount): string
    {
        return $discount . '%';
    }
}

if (!function_exists('miniText')) {
    function miniText(string $text = null, int $length = 100): string
    {
        if (strlen($text) && $text == null) {
            return '';
        }
        return mb_strimwidth(strip_tags($text), 0, $length, "...");
    }
}

if (!function_exists('dateFormat')) {
    function dateFormat(string $date = null): string|null
    {
        return $date ? date('Y-m-d', strtotime($date)) : null;
    }
}

if (!function_exists('discountPriceCalculate')) {
    function discountPriceCalculate(int $totalPrice, int $discount): int
    {
        return $totalPrice - ($totalPrice * ($discount / 100));
    }
}

if (!function_exists('invoiceIdGenerate')) {
    function invoiceIdGenerate(): int
    {
        return time() . rand(10, 99);
    }
}

if (!function_exists('fileSizeFormat')) {
    function fileSizeFormat(int $size): string
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');
        for ($i = 0; $size >= 1024 && $i < 4; $i++) {
            $size /= 1024;
        }
        return round($size) . ' ' . $units[$i];
    }
}

if (!function_exists('redirectPage')) {
    /**
     * @param string $routeName
     * @param string $message
     * @return \Illuminate\Http\RedirectResponse
     */
    function redirectPage(string $routeName, string $message): \Illuminate\Http\RedirectResponse
    {
        notify()->success('', $message);
        return redirect()->route($routeName);
    }
}

if (!function_exists('backPage')) {
    /**
     * @param string $message
     * @return \Illuminate\Http\RedirectResponse
     */
    function backPage(string $message): \Illuminate\Http\RedirectResponse
    {
        notify()->success('', $message);
        return back();
    }
}

if (!function_exists('backPageError')) {
    /**
     * @param string $message
     * @return \Illuminate\Http\RedirectResponse
     */
    function backPageError(string $message): \Illuminate\Http\RedirectResponse
    {
        notify()->error('', $message);
        return back();
    }
}

if (!function_exists('authHasRole')) {
    /**
     * @param string $roleName
     * @return bool
     */
    function authHasRole(string $roleName = 'developer'): bool
    {
        return auth()->user()->hasRole([$roleName]);
    }
}

if (!function_exists('isImageFile')) {

    function isImageFile(string $fileExtension): bool
    {
        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];
        return in_array(strtolower($fileExtension), $imageExtensions);
    }
}

if (!function_exists('getVendorCode')) {

    function getVendorCode(string $fileName): string
    {
        $patterns = ['/_.*/s', '/.png/s', '/.jpg/s', '/.jpeg/s', '/.gif/s', '/.bmp/s', '/.webp/s',];
        return preg_replace($patterns, '', $fileName);
    }
}
