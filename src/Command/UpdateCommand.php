<?php

namespace surangapg\HeavydGlobal\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Humbug\SelfUpdate\Updater;

class UpdateCommand extends Command {

  /**
   * @inheritdoc
   */
  protected function configure() {
    $this->setName('self-update')
      ->setDescription('Update the global cli to it\'s latest version');
  }

  /**
   * @inheritdoc
   */
  public function execute(InputInterface $input, OutputInterface $output) {

    $updater = new Updater(null, false, Updater::STRATEGY_GITHUB);

    try {
      $result = $updater->update();
      if($result) {
        $output->writeln('Updated from version <fg=yellow>' . $updater->getOldVersion() . '</> to  <fg=yellow>' . $updater->getNewVersion() . '</>');
      }
      else {
        $output->writeln('No Update needed');
      }
      exit(0);
    } catch (\Exception $e) {
      $output->writeln('Self update failed');
      $output->writeln($e->getMessage());
      exit(1);
    }
  }
}