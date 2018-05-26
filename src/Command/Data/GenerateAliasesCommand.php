<?php

namespace surangapg\HeavydGlobal\Command\Data;

use surangapg\HeavydComponents\BinRunner\PhingBinRunner;
use surangapg\HeavydComponents\Scope\ScopeInterface;
use surangapg\HeavydGlobal\Command\Base\GlobalCommandBase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;

class GenerateAliasesCommand extends GlobalCommandBase {

  /**
   * @inheritdoc
   */
  protected function configure() {
    $this->setName('data:generate-aliases')
      ->setDescription('Generate all the aliases from the data.');
  }

  /**
   * @inheritdoc
   */
  public function execute(InputInterface $input, OutputInterface $output) {
    $this->getIo()->title('Writing alias files');

    $globalFolder = $this->getApplication()->getProperties()->getBasePath(ScopeInterface::GLOBAL) . '/data';
    $properties = $this->getProperties()->get('global');
    $repositories = $properties['data_root_repositories'];
    if (is_string($repositories)) {
      $repositories = [$repositories];
    }

    foreach ($repositories as $repository) {
      $name = basename($repository);
      $name = str_replace('.git', '', $name);
      passthru(sprintf('cd %s && ./vendor/bin/phing project-data:generate-drush-aliases', $globalFolder. '/' . $name));
    }
  }
}
