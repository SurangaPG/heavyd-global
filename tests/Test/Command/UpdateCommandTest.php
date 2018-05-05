<?php

namespace surangapg\HeavydGlobal\Test\Command;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use surangapg\HeavydGlobal\Command\UpdateCommand;
use surangapg\HeavydGlobal\HeavydGlobalApplication;
use Symfony\Component\Console\Application;

class UpdateCommandTest extends TestCase {

  /**
   * Test the basic constructor.
   */
  public function testConstruct() {
    $command = new UpdateCommand();
    Assert::assertInstanceOf('Symfony\Component\Console\Command\Command', $command);
  }

}