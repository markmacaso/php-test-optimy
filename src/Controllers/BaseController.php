<?php declare(strict_types = 1);

namespace OptimyTest\Controllers;

use Twig\Environment;

/**
 * AbstractController for controller classes
 */
class BaseController
{
    /**
     * @var Environment
     */
    protected Environment $templater;

    /**
     * Set the templater
     *
     * @param  Environment $templater
     * @return BaseController
     */
    public function setTemplater(Environment $templater) : BaseController
    {
        $this->templater = $templater;

        return $this;
    }

    /**
     * Render html
     *
     * @param  string $template
     * @param  array $params
     * @return string
     */

    protected function view(string $template, $params = []) : string
    {
        return $this->templater->render($template, $params);
    }

    /**
     * Render the text return
     *
     * @param  string $template
     * @param  array $params
     * @return string
     */

     protected function text(string $text) : string
     {
         return $text . "\n";
     }
}