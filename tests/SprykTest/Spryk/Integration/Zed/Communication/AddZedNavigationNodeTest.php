<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykTest\Spryk\Integration\Zed\Communication;

use Codeception\Test\Unit;
use SprykTest\Module\ClassName;

/**
 * Auto-generated group annotations
 * @group SprykerTest
 * @group Spryk
 * @group Integration
 * @group Zed
 * @group Communication
 * @group AddZedNavigationNodeTest
 * Add your own group annotations below this line
 */
class AddZedNavigationNodeTest extends Unit
{
    /**
     * @var \SprykTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsZedNavigationSchemaFile(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--controller' => 'Index',
            '--method' => 'index',
        ]);

        $pathToNavigationSchema = $this->tester->getModuleDirectory() . 'src/Spryker/Zed/FooBar/Communication/navigation.xml';
        $this->assertFileExists($pathToNavigationSchema);

        $xmlContent = file_get_contents($pathToNavigationSchema);
        $xmlContent = ($xmlContent) ?: '';

        $this->assertRegExp('/\<bundle\>foo-bar\<\/bundle\>/', $xmlContent);
        $this->assertRegExp('/\<controller\>index\<\/controller\>/', $xmlContent);
        $this->assertRegExp('/\<action\>index\<\/action\>/', $xmlContent);
    }

    /**
     * @return void
     */
    public function testAddsZedNavigationSchemaFileOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--controller' => 'Index',
            '--method' => 'index',
            '--mode' => 'project',
        ]);

        $pathToNavigationSchema = $this->tester->getProjectModuleDirectory()
            . 'Communication/navigation.xml';
        $this->assertFileExists($pathToNavigationSchema);

        $xmlContent = file_get_contents($pathToNavigationSchema);
        $xmlContent = ($xmlContent) ?: '';

        $this->assertRegExp('/\<bundle\>foo-bar\<\/bundle\>/', $xmlContent);
        $this->assertRegExp('/\<controller\>index\<\/controller\>/', $xmlContent);
        $this->assertRegExp('/\<action\>index\<\/action\>/', $xmlContent);
    }

    /**
     * @return void
     */
    public function testAddsNodeToSchemaFileToFirstNode(): void
    {
        $pathToNavigationSchema = $this->tester->getModuleDirectory() . 'src/Spryker/Zed/FooBar/Communication/navigation.xml';
        if (!is_dir(dirname($pathToNavigationSchema))) {
            mkdir(dirname($pathToNavigationSchema), 0777, true);
        }
        $navigationSchemaContent = '<navigation><firstNode><pages></pages></firstNode></navigation>';
        file_put_contents($pathToNavigationSchema, $navigationSchemaContent);

        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--controller' => 'Index',
            '--method' => 'index',
        ]);

        $xmlContent = file_get_contents($pathToNavigationSchema);
        $xmlContent = ($xmlContent) ?: '';

        $this->assertRegExp('/\<bundle\>foo-bar\<\/bundle\>/', $xmlContent);
        $this->assertRegExp('/\<controller\>index\<\/controller\>/', $xmlContent);
        $this->assertRegExp('/\<action\>index\<\/action\>/', $xmlContent);
    }

    /**
     * @return void
     */
    public function testAddsNodeToSchemaFileToFirstNodeOnProjectLayer(): void
    {
        $pathToNavigationSchema = $this->tester->getProjectModuleDirectory() . 'Communication/navigation.xml';
        if (!is_dir(dirname($pathToNavigationSchema))) {
            mkdir(dirname($pathToNavigationSchema), 0777, true);
        }
        $navigationSchemaContent = '<navigation><firstNode><pages></pages></firstNode></navigation>';
        file_put_contents($pathToNavigationSchema, $navigationSchemaContent);

        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--controller' => 'Index',
            '--method' => 'index',
            '--mode' => 'project',
        ]);

        $xmlContent = file_get_contents($pathToNavigationSchema);
        $xmlContent = ($xmlContent) ?: '';

        $this->assertRegExp('/\<bundle\>foo-bar\<\/bundle\>/', $xmlContent);
        $this->assertRegExp('/\<controller\>index\<\/controller\>/', $xmlContent);
        $this->assertRegExp('/\<action\>index\<\/action\>/', $xmlContent);
    }

    /**
     * @return void
     */
    public function testAddsZedNavigationSchemaFileWithFullyQualifiedNames(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--controller' => ClassName::ZED_CONTROLLER,
            '--method' => 'indexAction',
        ]);

        $pathToNavigationSchema = $this->tester->getModuleDirectory() . 'src/Spryker/Zed/FooBar/Communication/navigation.xml';
        $this->assertFileExists($pathToNavigationSchema);

        $xmlContent = file_get_contents($pathToNavigationSchema);
        $xmlContent = ($xmlContent) ?: '';

        $this->assertRegExp('/\<bundle\>foo-bar\<\/bundle\>/', $xmlContent);
        $this->assertRegExp('/\<controller\>index\<\/controller\>/', $xmlContent);
        $this->assertRegExp('/\<action\>index\<\/action\>/', $xmlContent);
    }

    /**
     * @return void
     */
    public function testAddsZedNavigationSchemaFileWithFullyQualifiedNamesOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--controller' => ClassName::PROJECT_ZED_CONTROLLER,
            '--method' => 'indexAction',
            '--mode' => 'project',
        ]);

        $pathToNavigationSchema = $this->tester->getProjectModuleDirectory() . 'Communication/navigation.xml';
        $this->assertFileExists($pathToNavigationSchema);

        $xmlContent = file_get_contents($pathToNavigationSchema);
        $xmlContent = ($xmlContent) ?: '';

        $this->assertRegExp('/\<bundle\>foo-bar\<\/bundle\>/', $xmlContent);
        $this->assertRegExp('/\<controller\>index\<\/controller\>/', $xmlContent);
        $this->assertRegExp('/\<action\>index\<\/action\>/', $xmlContent);
    }
}
