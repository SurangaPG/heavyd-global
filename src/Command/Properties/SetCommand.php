<?php

namespace surangapg\HeavydGlobal\Command\Properties;

use surangapg\HeavydComponents\Scope\ScopeInterface;
use surangapg\HeavydGlobal\Command\Base\GlobalCommandBase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;

class SetCommand extends GlobalCommandBase {

  /**
   * @inheritdoc
   */
  protected function configure() {
    $this->setName('properties:set')
      ->setDescription('Set a global property.')
      ->addArgument('key')
      ->addArgument('value');
  }

  /**
   * @inheritdoc
   */
  public function execute(InputInterface $input, OutputInterface $output) {
    $output->writeln('Setting global properties config.');

    // If the global config file does not exist add it.
    $globalPropertiesFolder = $this->getApplication()->getProperties()->getPropertiesPath(TRUE, ScopeInterface::GLOBAL);
    if (!file_exists($globalPropertiesFolder)) {
      mkdir($globalPropertiesFolder);
    }
    $globalFile = $globalPropertiesFolder . '/global.yml';

    if (file_exists($globalFile)) {
      $data = Yaml::parseFile($globalFile);
    }
    else {
      $data = [];
    }

    $key = $input->getArgument('key');
    $value = explode(',', $input->getArgument('value'));
    if (count($value) == 1) {
      $value = reset($value);
    }

    $data[$key] = $value;

    file_put_contents($globalFile, Yaml::dump($data, 2));
    $this->getIo()->writeln('Wrote <fg=yellow>' . $key . '</>: <fg=yellow>' . $input->getArgument('value') . '</> to <fg=yellow>' . $globalFile . '</>');
  }
}