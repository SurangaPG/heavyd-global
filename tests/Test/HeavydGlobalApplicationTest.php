<?php

namespace surangapg\HeavydGlobal\Test;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use surangapg\HeavydComponents\Properties\Properties;
use surangapg\HeavydComponents\Scope\Scope;
use surangapg\HeavydComponents\Scope\ScopeInterface;
use surangapg\HeavydGlobal\HeavydGlobalApplication;
use Symfony\Component\Console\Application;

class HeavydGlobalApplicationTest extends TestCase {

  /**
   * Test that a default heavyd global application has the expected commands.
   *
   * @covers HeavydGlobalApplication::all
   */
  public function testAllCommandList() {
    $properties = new Properties();
    $application = new HeavydGlobalApplication($properties);
    $commands = $application->all();

    Assert::assertArrayHasKey('list', $commands);
    Assert::assertArrayHasKey('self-update', $commands);
    Assert::assertArrayHasKey('help', $commands);
  }


  /**
   * Get the basepath for the fixtures.
   *
   * @return string
   *   The basepath for the fixtures.
   */
  private function generateBasePath() {
    return dirname(__DIR__) . '/fixtures/sample-global-scope';
  }
}