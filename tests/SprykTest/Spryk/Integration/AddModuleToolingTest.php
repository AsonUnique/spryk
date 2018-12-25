<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykTest\Spryk\Integration;

use Codeception\Test\Unit;
use Symfony\Component\Yaml\Yaml;

/**
 * Auto-generated group annotations
 * @group SprykerTest
 * @group Spryk
 * @group Integration
 * @group AddSprykerToolingTest
 * Add your own group annotations below this line
 */
class AddModuleToolingTest extends Unit
{
    /**
     * @var \SprykTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return array
     */
    public function testAddsToolingFile(): array
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--organization' => 'Spryker',
        ]);

        static::assertFileExists($this->getToolingFilePath());

        return $this->getToolingConfigByFilePath($this->getToolingFilePath());
    }

    /**
     * @depends testAddsToolingFile
     *
     * @param array $toolingConfig
     *
     * @return void
     */
    public function testChecksToolingConfigHasCodeSnifferBlock(array $toolingConfig): void
    {
        static::assertArrayHasKey('code-sniffer', $toolingConfig);
    }

    /**
     * @param string $toolingFilePath
     *
     * @return array
     */
    protected function getToolingConfigByFilePath(string $toolingFilePath): array
    {
        return Yaml::parseFile($toolingFilePath);
    }

    /**
     * @return string
     */
    protected function getToolingFilePath(): string
    {
        return $this->tester->getModuleDirectory() . 'tooling.yml';
    }
}
