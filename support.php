<?php
//env 輔助函式
if (!function_exists('env'))
{
    function env($key, $default = null) {
        $value = getenv($key);
        if ($value === false) {
            return $default;
        }
        return $value;
    }
}

//request 輔助函式
if(!function_exists('request'))
{
    function request() {
        return new Request();
    }
}

//view 輔助函式
if(!function_exists('view'))
{
    function view($blade,$data=[]){
        global $viewer;
        return $viewer->render($blade,$data);
    }
}

//public目錄路徑 輔助函式
if(!function_exists('public_path'))
{
    function public_path($path){
        return __public__."/".$path;
    }
}

//URL 輔助類別 (協定通用)
class URL {
    public static function asset($path) {
        // 取得應用的基礎 URL
        $baseUrl = self::baseUrl();

        // 確保資源路徑的前綴是正確的
        $path = ltrim($path, '/');

        // 返回完整的資源 URL
        return $baseUrl.$path;
    }

    private static function baseUrl() {
        // 獲取基本的 URL
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $host = $_SERVER['HTTP_HOST'];
        $scriptName = dirname($_SERVER['SCRIPT_NAME']);

        return $protocol . $host . $scriptName;
    }
}

//資源(js css img) 輔助函式
if(!function_exists('asset'))
{
    function asset($path){
        return URL::asset($path);
    }
}
