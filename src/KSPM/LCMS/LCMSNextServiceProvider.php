<?php

namespace KSPM\LCMS;

use Illuminate\Support\ServiceProvider;

define ('_LCMS_PREFIX_', (config('laikacms.default.uri-prefix'))?config('laikacms.default.uri-prefix'):'laikacms');

class LCMSNextServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot() {
        //$this->package('kspm/laikacms');
        include app_path() . '/Http/routes.php';
        include __DIR__ . '/../../routes.php';
        $this->registerBladeExtensions();
        $this->loadViewsFrom(__DIR__ . '/../../views', 'laikacms');
        $this->publishes([
            __DIR__ . '/../../../public' => public_path('packages/kspm/laikacms'),
                ], 'public');
        
        $this->publishes([
            __DIR__.'/../../config/laikacms.php' => config_path('laikacms.php'),
        ], 'config');
        
         $this->publishes([
        __DIR__.'/../../migrations/' => database_path('/migrations')
        ], 'migrations');

    }

    public function registerBladeExtensions() {
        \Blade::extend(function($view, $compiler) {
            $pattern = '/@content\(\'(.*?)\'\)(.*?)@endcontent/is';
            preg_match_all($pattern, $view, $result);
            if (is_array($result)) {
                for ($i = 0; count($result[1]) > $i; $i++) {
                    $replace = $result[0][$i];
                    $key = $result[1][$i];
                    $value = $result[2][$i];
                    if ($key && $value) {
                        $o = \KSPM\LCMS\Model\Content::where('key', '=', $key)->first();
                        if (!$o) {
                            $o = \KSPM\LCMS\Model\Content::create(array('key' => $key, 'value' => $value));
                        }
                        $o = "<?php echo \KSPM\LCMS\Model\Content::where('key', '=', '{$key}')->first()->value; ?>";
                        $view = str_replace($replace, $o, $view);
                    }
                }
            }
            $pattern = '/@editable_content\(\'(.*?)\'\)(.*?)@endeditable_content/is';
            preg_match_all($pattern, $view, $result);
            $cmswrapper = '<div class="laikacms-editable" data-id="%%%oid%%%">%%%php%%%</div>';
            if (is_array($result)) {
                for ($i = 0; count($result[1]) > $i; $i++) {
                    $replace = $result[0][$i];
                    $key = $result[1][$i];
                    $value = $result[2][$i];
                    if ($key && $value) {
                        $o = \KSPM\LCMS\Model\Content::where('key', '=', $key)->first();
                        if (!$o) {
                            $o = \KSPM\LCMS\Model\Content::create(array('key' => $key, 'value' => $value));
                        }
                        $o = "<?php \$c = \KSPM\LCMS\Model\Content::where('key', '=', '{$key}')->first()->value; echo str_replace('%%%oid%%%','{$o->id}', str_replace('%%%php%%%', \$c, '{$cmswrapper}')); ?>";
                        $view = str_replace($replace, $o, $view);
                    }
                }
            }

            return $view;
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {
        //
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides() {
        return array();
    }

}
