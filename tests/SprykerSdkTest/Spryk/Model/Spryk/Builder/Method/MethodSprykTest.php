<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerTest\Spryk\Model\Spryk\Builder\Method;

use Codeception\Test\Unit;
use Roave\BetterReflection\Reflection\ReflectionClass;
use SprykerSdk\Spryk\Exception\EmptyFileException;
use SprykerSdk\Spryk\Exception\ReflectionException;
use SprykerSdk\Spryk\Model\Spryk\Builder\Method\MethodSpryk;
use SprykerSdk\Spryk\Style\SprykStyleInterface;

/**
 * Auto-generated group annotations
 * @group SprykerSdkTest
 * @group Spryk
 * @group Model
 * @group Builder
 * @group Method
 * @group MethodSprykTest
 * Add your own group annotations below this line
 */
class MethodSprykTest extends Unit
{
    public const ARGUMENT_TARGET = '';
    public const EMPTY_FILE_NAME = 'emptyFile';

    /**
     * @var \SprykerSdkTest\SprykTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        file_put_contents($this->tester->getRootDirectory() . static::EMPTY_FILE_NAME, '');
    }

    /**
     * @return void
     */
    public function testBuildThrowsExceptionWhenReflectionClassFilenameIsNull()
    {
        $this->expectException(ReflectionException::class);

        $methodSpryk = $this->buildMethodSprykMockWithEmptyFileNameOfReflectionClass();
        $methodSpryk->build(
            $this->tester->getSprykDefinition([MethodSpryk::ARGUMENT_TARGET => static::ARGUMENT_TARGET]),
            $this->getSprykStyleMock()
        );
    }

    /**
     * @return void
     */
    public function testBuildThrowsExceptionWhenTargetFileIsEmpty()
    {
        $this->expectException(EmptyFileException::class);

        $methodSpryk = $this->buildMethodSprykMockWithEmptyTargetFile();
        $methodSpryk->build(
            $this->tester->getSprykDefinition([MethodSpryk::ARGUMENT_TARGET => static::ARGUMENT_TARGET]),
            $this->getSprykStyleMock()
        );
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|\SprykerSdk\Spryk\Model\Spryk\Builder\SprykBuilderInterface
     */
    protected function buildMethodSprykMockWithEmptyFileNameOfReflectionClass()
    {
        $mockBuilder = $this->getMockBuilder(MethodSpryk::class)
            ->disableOriginalConstructor()
            ->setMethods(['getReflection']);

        $methodSprykMock = $mockBuilder->getMock();
        $methodSprykMock
            ->expects(Unit::once())
            ->method('getReflection')
            ->willReturn(
                $this->buildReflectionClassMock()
            );

        return $methodSprykMock;
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|\SprykerSdk\Spryk\Model\Spryk\Builder\SprykBuilderInterface
     */
    protected function buildMethodSprykMockWithEmptyTargetFile()
    {
        $mockBuilder = $this->getMockBuilder(MethodSpryk::class)
            ->disableOriginalConstructor()
            ->setMethods(['getTargetFilename']);

        $methodSprykMock = $mockBuilder->getMock();
        $methodSprykMock
            ->expects(Unit::once())
            ->method('getTargetFilename')
            ->willReturn(
                codecept_data_dir() . static::EMPTY_FILE_NAME
            );

        return $methodSprykMock;
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|\Roave\BetterReflection\Reflection\ReflectionClass
     */
    protected function buildReflectionClassMock()
    {
        $mockBuilder = $this->getMockBuilder(ReflectionClass::class)
            ->disableOriginalConstructor()
            ->setMethods(['getFilename']);

        $reflectionClassMock = $mockBuilder->getMock();
        $reflectionClassMock->expects(Unit::once())->method('getFilename')->willReturn(null);

        return $reflectionClassMock;
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|\SprykerSdk\Spryk\Style\SprykStyleInterface
     */
    protected function getSprykStyleMock()
    {
        $mockBuilder = $this->getMockBuilder(SprykStyleInterface::class);

        return $mockBuilder->getMock();
    }
}
