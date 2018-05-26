<?php

namespace surangapg\HeavydGlobal;

use surangapg\HeavydComponents\Application\ApplicationInterface;
use surangapg\HeavydComponents\Properties\Properties;
use surangapg\HeavydComponents\Properties\PropertiesInterface;
use surangapg\HeavydComponents\Scope\ScopeInterface;
use surangapg\HeavydGlobal\Command\Properties\SetCommand as PropertiesSetCommand;
use surangapg\HeavydGlobal\Command\Data\GetCommand as DataGetCommand;
use surangapg\HeavydGlobal\Command\UpdateCommand;
use Symfony\Component\Console\Application;

class HeavydGlobalApplication extends Application implements ApplicationInterface {

  /**
   * Version for the item.
   */
  const VERSION = '@package_version@';

  /**
   * All the properties for the project.
   *
   * @var \surangapg\HeavydComponents\Properties\PropertiesInterface
   *   Properties interface to handle to properties for the project.
   */
  protected $properties;

  /**
   * Creates and returns a fully functional heavyd application based on the current
   * data in a selected heavyd project (this is auto detected).
   *
   * @param ScopeInterface[] $scopes
   *   The various scopes available to the application.
   *
   * @return HeavydGlobalApplication
   *   Fully build application.
   *
   * @throws \Exception
   *   If the project scope was invalid. E.g when run in a tree that identifies
   *   as a heavyD project but without the needed marker to recognize the root.
   */
  public static function create(array $scopes = []) {

    if (!isset($scopes['global'])) {
      throw new \Exception("Couldn't locate .heavyd marker in any of the directories. Are you sure heavyd has been properly initialized?");
    }

    $properties = new Properties();
    $properties->setScopes($scopes, TRUE);

    // Fully initialize the application with any extra data from the data file.
    $application = new self($properties);

    return $application;
  }

  /**
   * HeavydGlobalApplication constructor.
   *
   * @param PropertiesInterface $properties
   *   The different scopes to be loaded in.
   */
  public function __construct(PropertiesInterface $properties) {
    parent::__construct('heavyd-global', $this::VERSION);

    $this->setProperties($properties);

    $this->add(new UpdateCommand());
    $this->add(new PropertiesSetCommand());
    $this->add(new DataGetCommand());
  }

  /**
   * @return \surangapg\HeavydComponents\Properties\PropertiesInterface
   */
  public function getProperties() {
    return $this->properties;
  }

  /**
   * @param \surangapg\HeavydComponents\Properties\PropertiesInterface $properties
   */
  public function setProperties(PropertiesInterface $properties) {
    $this->properties = $properties;
  }

}