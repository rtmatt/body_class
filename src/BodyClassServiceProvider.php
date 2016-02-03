<?php

namespace Rtmatt\BodyClass;


use Illuminate\Support\ServiceProvider;
use Jenssegers\Agent\Agent;

class BodyClassServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $body_class = $this->getBodyClass();

        view()->composer('layouts.main', function ($view) use ($body_class) {

            $view->with(compact('body_class'));
        });
    }


    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }


    private function getBodyClass()
    {


        $agent = new Agent();
        $browser_css_classes = array();
        $unsupported = [];


        if($mobile = $agent->isMobile()) {
            $browser_css_classes[] = 'device-mobile';
        }

        if($tablet = $agent->isTablet()) {
            $browser_css_classes[] = 'device-tablet';
        }

        if($iphone = $agent->is('iPhone')) {
            $browser_css_classes[] = 'device-iphone';
        }

        if($ipad = $agent->is('iPad')) {
            $browser_css_classes[] = 'device-ipad';
        }

        if($agent->browser() == "Safari") {
            $browser_css_classes[] = 'browser-safari';
            if($agent->version('Safari')<5){
                $unsupported['browser'] = 'Safari';
            }
        }

        if($agent->browser() == "Chrome") {
            $browser_css_classes[] = 'browser-chrome';
            $browser_css_classes[] = 'browser-chrome-'.(int)$agent->version('Chrome');
            if($agent->version('Chrome')<30){
                $unsupported['browser'] = 'Chrome';
            }
        }

        if($agent->browser() == "Firefox") {
            $browser_css_classes[] = 'browser-firefox';
            $browser_css_classes[] = 'browser-firefox-'.(int)$agent->version('Firefox');
            if($agent->version('Firefox')<25){
                $unsupported['browser'] = 'Firefox';
            }
        }

        if($browser = $agent->browser() == "IE") {
            $version = $agent->version("IE");
            $version = str_replace('.0','',$version);

            $browser_css_classes[] = 'browser-ie';
            $browser_css_classes[] = 'browser-ie-'.(int)$version;
            if((int)$version<10){
                $browser_css_classes[] = 'browser-lt-ie10';
            }
            if((int)$version<9){
                $unsupported['browser'] = 'Internet Explorer';;
            }
            $browser_css_classes[] = 'browser-ie'.$version;
        }

        if($agent->is('Windows')) {
            $browser_css_classes[] = 'os-windows';
        }

        if($agent->is('OS X')) {
            $browser_css_classes[] = 'os-mac';
        }
        if ($agent->isDesktop()){
            $browser_css_classes[] = 'desktop';
        }
        else{
            //Don't display errors on non-desktop devices
            $unsupported=[];
        }
        $browser_css_classes = implode(' ', $browser_css_classes);

        return $browser_css_classes;

    }
}
