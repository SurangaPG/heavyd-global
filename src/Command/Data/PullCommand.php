<?php

namespace surangapg\HeavydGlobal\Command\Data;

use surangapg\HeavydComponents\Scope\ScopeInterface;
use surangapg\HeavydGlobal\Command\Base\GlobalCommandBase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;

class PullCommand extends GlobalCommandBase {

  /**
   * @inheritdoc
   */
  protected function configure() {
    $this->setName('data:pull')
      ->setDescription('get the global data set from a git remote.');
  }

  /**
   * @inheritdoc
   */
  public function execute(InputInterface $input, OutputInterface $output) {
    $this->getIo()->title('Pulling');

    $properties = $this->getProperties()->get('global');

    if (!isset($properties['data_root_repositories'])) {
      $this->getIo()->error('The "data_root_repositories" was not listed. Add one via "properties:set data_root_repositories REPO_INFO"');
      exit(1);
    }

    // Ensure the global data dir exists.
    $globalFolder = $this->getApplication()->getProperties()->getBasePath(ScopeInterface::GLOBAL) . '/data';
    if (!file_exists($globalFolder)) {
      mkdir($globalFolder);
    }

    $repositories = $properties['data_root_repositories'];
    if (is_string($repositories)) {
      $repositories = [$repositories];
    }

    foreach ($repositories as $repository) {
      $name = basename($repository);
      $name = str_replace('.git', '', $name);

      if (!file_exists($globalFolder . '/' . $name)) {
        $this->getIo()->writeln('<fg=yellow>Cloning ' . $name . '</>');
        passthru(sprintf('cd %s && git clone %s %s', $globalFolder, $repository, $name));
      }
      else {
        $this->getIo()->writeln('<fg=yellow>Pulling ' . $name . '</>');
        passthru(sprintf('cd %s && git pull', $globalFolder . '/' . $name));
      }

      $this->getIo()->writeln('<fg=yellow>Installing dependencies ' . $name . '</>');
      passthru(sprintf('cd %s && composer install --no-progress --no-suggest', $globalFolder . '/' . $name));

      $homeDrushDir = '';
      exec('cd && pwd', $homeDrushDir);
      $homeDrushDir = $homeDrushDir[0];
      $homeDrushDir .= '/.drush';

      if (!file_exists($homeDrushDir)) {
        mkdir($homeDrushDir);
        mkdir($homeDrushDir . '/site-aliases');
      }

      if (!file_exists($homeDrushDir . '/site-aliases/' . $name)) {
        $this->getIo()->writeln('<fg=yellow>Symlinking folders ' . $name . '</>');
        passthru(sprintf('ln -s %s %s', $globalFolder . '/' . $name . '/drush-aliases', $homeDrushDir . '/site-aliases/' . $name));

      }
    }
  }
}
