<?php

namespace surangapg\HeavydGlobal;

use Symfony\Component\Console\Application;

class HeavydGlobalApplication extends Application {

  const VERSION = '@package_version@';

  /**
   * @var string $basePath;
   */
  protected $basePath;

  public function __construct() {
    parent::__construct('heavyd-global', $this::VERSION);

    $this->setBasePath();
  }

  public function setBasePath() {
    $this->basePath = getcwd();
  }

  public function getBasePath() {
    return $this->basePath;
  }
}