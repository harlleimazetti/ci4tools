<?php namespace Harlleimazetti\Ci4tools\Templateparser;

use \Mustache_Engine as Mustache;

class TemplateParser
{
  protected $renderer;

  function __construct()
  {
    $this->renderer = new Mustache();
  }

  public function render($template, $vars) {
    return $this->renderer->render($template, $vars);
  }
}
