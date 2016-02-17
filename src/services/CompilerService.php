<?php

namespace KSPM\LCMS\Service;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class CompilerService {

    private $_page;
    private $_template;
    private $_content;
    
    protected $customDirectives = [];
   

    public function __construct(\KSPM\LCMS\Model\Page $page) {
        $this->_template = $page->template;
        $this->_page = $page;
        $this->_content = $page->content;
        
        return $this;
    }
    
    /**
     * 
     * @param \KSPM\LCMS\Model\Page $page
     * @param array $options
     * @return \KSPM\LCMS\Service\RenderPageService
     */
    public static function init(\KSPM\LCMS\Model\Page $page, $options = array()){
        $service = new CompilerService($page);
        return $service;
    }
    
    public static function cleanup($content){
         $callback = function ($match) {
			return '';
        };

       return preg_replace('/\B@(\w+)([ \t]*)(\( ( (?>[^()]+) | (?3) )* \))?/x', '', $content);
    }
    
    public function compile(){
        $result = TagParserService::instance()->compile($this->_template, $this->_content);
        return $this->_compilePageVars($result);
    }
    
    private function _compilePageVars($content){
        return $this->_tagEcho($this->compileStatements($content));
    }
    
    private function _tagEcho($content){
        $pattern = sprintf('/%s\s*(.+?)\s*%s(\r?\n)?/s', '{{', '}}');
        return preg_replace($pattern, '<?php echo $1; ?>', $content);
    }
    
    protected function compileStatements($value)
    {
        $callback = function ($match) {
            if (method_exists($this, $method = 'compile'.ucfirst($match[1]))) {
                $match[0] = $this->$method(array_get($match, 3));
            } elseif (isset($this->customDirectives[$match[1]])) {
                $match[0] = call_user_func($this->customDirectives[$match[1]], array_get($match, 3));
            }

            return isset($match[3]) ? $match[0] : $match[0].$match[2];
        };

        return preg_replace_callback('/\B@(\w+)([ \t]*)(\( ( (?>[^()]+) | (?3) )* \))?/x', $callback, $value);
    }
    
     /**
     * Compile the unless statements into valid PHP.
     *
     * @param  string  $expression
     * @return string
     */
    protected function compileUnless($expression)
    {
        return "<?php if ( ! $expression): ?>";
    }

    /**
     * Compile the end unless statements into valid PHP.
     *
     * @param  string  $expression
     * @return string
     */
    protected function compileEndunless($expression)
    {
        return '<?php endif; ?>';
    }

    /**
     * Compile the lang statements into valid PHP.
     *
     * @param  string  $expression
     * @return string
     */
    protected function compileLang($expression)
    {
        return "<?php echo \\Illuminate\\Support\\Facades\\Lang::get$expression; ?>";
    }

    /**
     * Compile the choice statements into valid PHP.
     *
     * @param  string  $expression
     * @return string
     */
    protected function compileChoice($expression)
    {
        return "<?php echo \\Illuminate\\Support\\Facades\\Lang::choice$expression; ?>";
    }

    /**
     * Compile the else statements into valid PHP.
     *
     * @param  string  $expression
     * @return string
     */
    protected function compileElse($expression)
    {
        return '<?php else: ?>';
    }

    /**
     * Compile the for statements into valid PHP.
     *
     * @param  string  $expression
     * @return string
     */
    protected function compileFor($expression)
    {
        return "<?php for{$expression}: ?>";
    }

    /**
     * Compile the foreach statements into valid PHP.
     *
     * @param  string  $expression
     * @return string
     */
    protected function compileForeach($expression)
    {
        return "<?php foreach{$expression}: ?>";
    }

    /**
     * Compile the forelse statements into valid PHP.
     *
     * @param  string  $expression
     * @return string
     */
    protected function compileForelse($expression)
    {
        $empty = '$__empty_'.++$this->forelseCounter;

        return "<?php {$empty} = true; foreach{$expression}: {$empty} = false; ?>";
    }

    /**
     * Compile the if statements into valid PHP.
     *
     * @param  string  $expression
     * @return string
     */
    protected function compileIf($expression)
    {
        return "<?php if{$expression}: ?>";
    }

    /**
     * Compile the else-if statements into valid PHP.
     *
     * @param  string  $expression
     * @return string
     */
    protected function compileElseif($expression)
    {
        return "<?php elseif{$expression}: ?>";
    }

    /**
     * Compile the forelse statements into valid PHP.
     *
     * @param  string  $expression
     * @return string
     */
    protected function compileEmpty($expression)
    {
        $empty = '$__empty_'.$this->forelseCounter--;

        return "<?php endforeach; if ({$empty}): ?>";
    }

    /**
     * Compile the while statements into valid PHP.
     *
     * @param  string  $expression
     * @return string
     */
    protected function compileWhile($expression)
    {
        return "<?php while{$expression}: ?>";
    }

    /**
     * Compile the end-while statements into valid PHP.
     *
     * @param  string  $expression
     * @return string
     */
    protected function compileEndwhile($expression)
    {
        return '<?php endwhile; ?>';
    }

    /**
     * Compile the end-for statements into valid PHP.
     *
     * @param  string  $expression
     * @return string
     */
    protected function compileEndfor($expression)
    {
        return '<?php endfor; ?>';
    }

    /**
     * Compile the end-for-each statements into valid PHP.
     *
     * @param  string  $expression
     * @return string
     */
    protected function compileEndforeach($expression)
    {
        return '<?php endforeach; ?>';
    }

    /**
     * Compile the end-if statements into valid PHP.
     *
     * @param  string  $expression
     * @return string
     */
    protected function compileEndif($expression)
    {
        return '<?php endif; ?>';
    }

    /**
     * Compile the end-for-else statements into valid PHP.
     *
     * @param  string  $expression
     * @return string
     */
    protected function compileEndforelse($expression)
    {
        return '<?php endif; ?>';
    }
    
   

}
