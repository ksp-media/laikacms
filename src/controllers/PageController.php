<?php

namespace KSPM\LCMS\Controllers;

use KSPM\LCMS\Service\CompilerService as Compiler;

class PageController extends \Illuminate\Routing\Controller {

    public function __construct() {
        \View::addNamespace('pages', app_path() . '/../modules/pages/views');
    }

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected function setupLayout() {
        if (!is_null($this->layout)) {
            $this->layout = \View::make($this->layout);
        }

    }
     
    public function showAction($key = false) {
        $key = ($key) ? $key : Route::current()->uri();
        if ($key == "/") {
            $key = config('laikacms.default.baseroute');
        }
        //if(\Cache::has($key)){
        //    return \Cache::get($key);
        // }
        $content = \KSPM\LCMS\Model\Page::where('slug', '=', $key)->first();
        if (!$content) {
            $content = \KSPM\LCMS\Model\Content::where('key', '=', 'error.pagecontent.notfound')->first();
        }

        $renderResult = \View::make('pages::show', array('content' => Compiler::init($content)->compile()))->render();
        
        ob_start();
        eval('$page=$content;$cmsprefix=_JBKCMS_PREFIX_; ?>' . $renderResult . '<?php ');
        return ob_get_clean();
    }

}
