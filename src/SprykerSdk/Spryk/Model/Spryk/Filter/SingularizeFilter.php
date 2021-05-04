<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Filter;

use SprykerSdk\Spryk\Model\Spryk\Inflector\SingularizerInterface;

class SingularizeFilter implements FilterInterface
{
    protected const FILTER_NAME = 'singularize';

    /**
     * @var \SprykerSdk\Spryk\Model\Spryk\Inflector\SingularizerInterface
     */
    protected $singularizer;

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Inflector\SingularizerInterface $singularizer
     */
    public function __construct(SingularizerInterface $singularizer)
    {
        $this->singularizer = $singularizer;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return static::FILTER_NAME;
    }

    /**
     * @param string $value
     *
     * @return string
     */
    public function filter(string $value): string
    {
        return $this->singularizer->singularize($value);
    }
}
