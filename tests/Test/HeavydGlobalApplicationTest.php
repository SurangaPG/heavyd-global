<?php

namespace surangapg\HeavydGlobal\Test;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use surangapg\HeavydGlobal\HeavydGlobalApplication;
use Symfony\Component\Console\Application;

class HeavydGlobalApplicationTest extends TestCase {

  /**
   * Test that a default heavyd global application has the expected commands.
   *
   * @covers HeavydGlobalApplication::all
   */
  public function testAllCommandList() {
    $application = new HeavydGlobalApplication();
    $commands = $application->all();

    Assert::assertArrayHasKey('list', $commands);
    Assert::assertArrayHasKey('help', $commands);
  }

}