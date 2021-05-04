<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Inflector;

use Doctrine\Inflector\InflectorFactory;
use Laminas\Filter\Inflector;
use Doctrine\Common\Inflector\Inflector as DeprecatedInflector;

if (class_exists(Inflector::class)) {
    class Singularizer implements SingularizerInterface
    {
        /**
         * @param string $value
         *
         * @return string
         */
        public function singularize(string $value): string
        {
            $inflector = InflectorFactory::create()->build();

            return $inflector->singularize($value);
        }
    }
} else {
    class Singularizer implements SingularizerInterface
    {
        /**
         * @param string $value
         *
         * @return string
         */
        public function singularize(string $value): string
        {
            return DeprecatedInflector::singularize($value);
        }
    }
}
