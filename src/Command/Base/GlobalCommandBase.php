<?php
/**
 * @file
 * Contains a basic global command with some helpers. This is mainly because
 * the global scope doesn't always have a set of config etc but we do want
 * to have some basic functionallity.
 */

namespace surangapg\HeavydGlobal\Command\Base;

use surangapg\HeavydComponents\Application\ApplicationInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Yaml\Yaml;

abstract class GlobalCommandBase extends Command {

  /**
   * @var SymfonyStyle
   */
  public $Io;

  /**
   * Extra initialize step to generate a symfony style Io object.
   *
   * @param \Symfony\Component\Console\Input\InputInterface $input
   *   Input for the command.
   * @param \Symfony\Component\Console\Output\OutputInterface $output
   *   Output for the command.
   */
  public function initialize(InputInterface $input, OutputInterface $output) {
    parent::initialize($input, $output);

    $this->setIo(new SymfonyStyle($input, $output));
  }

  /**
   * Get the IO handler.
   *
   * @return SymfonyStyle
   *   The IO handler.
   */
  public function getIo() {
    return $this->Io;
  }

  /**
   * Set the Io handler.
   *
   * @param SymfonyStyle $Io
   *   The IO handler.
   */
  public function setIo(SymfonyStyle $Io) {
    $this->Io = $Io;
  }

  /**
   * @return ApplicationInterface
   */
  public function getApplication() {
    return parent::getApplication();
  }

  /**
   * @return \surangapg\HeavydComponents\Properties\PropertiesInterface
   */
  public function getProperties() {
    return $this->getApplication()->getProperties();
  }
}