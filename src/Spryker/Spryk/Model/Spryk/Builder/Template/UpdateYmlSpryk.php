<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Model\Spryk\Builder\Template;

use Spryker\Spryk\Exception\YmlException;
use Spryker\Spryk\Model\Spryk\Builder\SprykBuilderInterface;
use Spryker\Spryk\Model\Spryk\Builder\Template\Renderer\TemplateRendererInterface;
use Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface;
use Spryker\Spryk\Style\SprykStyleInterface;
use Symfony\Component\Yaml\Yaml;

class UpdateYmlSpryk implements SprykBuilderInterface
{
    const ARGUMENT_TARGET_PATH = 'targetPath';
    const ARGUMENT_TEMPLATE = 'template';

    const ARGUMENT_AFTER_ELEMENT = 'afterElement';
    const ARGUMENT_ADD_TO_ELEMENT = 'addToElement';
    const ARGUMENT_CONTENT = 'content';

    const YAML_START_INLINE_LEVEL = 10;

    /**
     * @var \Spryker\Spryk\Model\Spryk\Builder\Template\Renderer\TemplateRendererInterface
     */
    protected $renderer;

    /**
     * @var string
     */
    protected $rootDirectory;

    /**
     * @param \Spryker\Spryk\Model\Spryk\Builder\Template\Renderer\TemplateRendererInterface $renderer
     * @param string $rootDirectory
     */
    public function __construct(TemplateRendererInterface $renderer, string $rootDirectory)
    {
        $this->renderer = $renderer;
        $this->rootDirectory = $rootDirectory;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'update-yml';
    }

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return bool
     */
    public function shouldBuild(SprykDefinitionInterface $sprykDefinition): bool
    {
        return true;
    }

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     * @param \Spryker\Spryk\Style\SprykStyleInterface $style
     *
     * @return void
     */
    public function build(SprykDefinitionInterface $sprykDefinition, SprykStyleInterface $style): void
    {
        $targetYaml = $this->getTargetYaml($sprykDefinition);
        $targetYaml = $this->updateYaml($sprykDefinition, $targetYaml);

        $this->dumpYamlToFile($sprykDefinition, $targetYaml);

        $style->report(sprintf('Updated <fg=green>%s</>', $this->getTargetPath($sprykDefinition)));
    }

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return array
     */
    protected function getTargetYaml(SprykDefinitionInterface $sprykDefinition): array
    {
        $targetYaml = $this->getTargetYamlAsArray($sprykDefinition);
        $targetYaml = $this->prepareTargetYaml($sprykDefinition, $targetYaml);

        return $targetYaml;
    }

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @throws \Spryker\Spryk\Exception\YmlException
     *
     * @return array
     */
    protected function getTargetYamlAsArray(SprykDefinitionInterface $sprykDefinition): array
    {
        $targetPath = $this->getTargetPath($sprykDefinition);
        $fileContent = file_get_contents($targetPath);

        if ($fileContent === false || strlen($fileContent) === 0) {
            throw new YmlException(sprintf('Could not load yaml content from "%s"!', $targetPath));
        }

        $yaml = Yaml::parse($fileContent);

        return $yaml;
    }

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     * @param array $targetYaml
     *
     * @return array
     */
    protected function prepareTargetYaml(SprykDefinitionInterface $sprykDefinition, array $targetYaml): array
    {
        $addToElement = $this->getAddToElement($sprykDefinition);
        $afterElement = $this->getAfterElement($sprykDefinition);

        $newTargetYaml = [];

        if (!isset($targetYaml[$addToElement])) {
            foreach ($targetYaml as $key => $value) {
                $newTargetYaml[$key] = $value;
                if ($key === $afterElement) {
                    $newTargetYaml[$addToElement] = [];
                }
            }
            $targetYaml = $newTargetYaml;
        }

        return $targetYaml;
    }

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return string
     */
    protected function getTargetPath(SprykDefinitionInterface $sprykDefinition): string
    {
        $targetPath = $sprykDefinition
            ->getArgumentCollection()
            ->getArgument(static::ARGUMENT_TARGET_PATH)
            ->getValue();

        return $this->rootDirectory . $targetPath;
    }

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return mixed
     */
    protected function getYamlToAdd(SprykDefinitionInterface $sprykDefinition)
    {
        if ($sprykDefinition->getArgumentCollection()->hasArgument(self::ARGUMENT_CONTENT)) {
            return $sprykDefinition->getArgumentCollection()->getArgument(self::ARGUMENT_CONTENT)->getValue();
        }

        return $this->getSourceYamlAsArray($sprykDefinition);
    }

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return array
     */
    protected function getSourceYamlAsArray(SprykDefinitionInterface $sprykDefinition): array
    {
        $content = $this->getContent($sprykDefinition, $this->getTemplateName($sprykDefinition));
        $yaml = Yaml::parse($content);

        return $yaml;
    }

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return string
     */
    protected function getTemplateName(SprykDefinitionInterface $sprykDefinition): string
    {
        $templateName = $sprykDefinition
            ->getArgumentCollection()
            ->getArgument(static::ARGUMENT_TEMPLATE)
            ->getValue();

        return $templateName;
    }

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     * @param string $templateName
     *
     * @return string
     */
    protected function getContent(SprykDefinitionInterface $sprykDefinition, string $templateName): string
    {
        return $this->renderer->render(
            $templateName,
            $sprykDefinition->getArgumentCollection()->getArguments()
        );
    }

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     * @param array $targetYaml
     *
     * @return array
     */
    protected function updateYaml(SprykDefinitionInterface $sprykDefinition, array $targetYaml): array
    {
        $content = $this->getYamlToAdd($sprykDefinition);
        $addToElement = $this->getAddToElement($sprykDefinition);

        if (is_array($content)) {
            $targetYaml[$addToElement] = array_merge($targetYaml[$addToElement], $content);

            return $targetYaml;
        }

        if (in_array($content, $targetYaml[$addToElement], true)) {
            return $targetYaml;
        }

        $targetYaml[$addToElement][] = $content;

        return $targetYaml;
    }

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return string
     */
    protected function getAddToElement(SprykDefinitionInterface $sprykDefinition): string
    {
        $addToElement = $sprykDefinition
            ->getArgumentCollection()
            ->getArgument(static::ARGUMENT_ADD_TO_ELEMENT)
            ->getValue();

        return $addToElement;
    }

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return string
     */
    protected function getAfterElement(SprykDefinitionInterface $sprykDefinition): string
    {
        $afterElement = $sprykDefinition
            ->getArgumentCollection()
            ->getArgument(static::ARGUMENT_AFTER_ELEMENT)
            ->getValue();

        return $afterElement;
    }

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     * @param array $targetYaml
     *
     * @return void
     */
    protected function dumpYamlToFile(SprykDefinitionInterface $sprykDefinition, array $targetYaml): void
    {
        $yamlContent = Yaml::dump($targetYaml, static::YAML_START_INLINE_LEVEL);

        file_put_contents($this->getTargetPath($sprykDefinition), $yamlContent);
    }
}
