<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class BladeServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * CSSファイルやJSファイルのパスに、ファイルのタイムスタンプを追加
         *
         * @param  string $file
         * @return string
         */
        Blade::directive('asset', function ($file) {
            $file = str_replace(["'", '"'], '', $file);
            $path = public_path() . '/' . $file;

            try {
                $timestamp = "?<?php echo \File::lastModified('{$path}') ?>";
            } catch (\Exception $e) {
                $timestamp = '';
            }

            return asset($file) . $timestamp;
/*
            // ロードバランサーを考慮する場合（環境によってはURLを自動取得できないので、.envのAPP_URLを参照）
            $app_url = env('APP_URL');

            if (empty($app_url)) {
                return asset($file) . $timestamp;
            } else {
                return $app_url . '/' . $file . $timestamp;
            }
*/
        });
    }
}
