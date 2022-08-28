<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Middleware\Transforms;

use KrisKuiper\Validator\Blueprint\Contracts\MiddlewareFieldInterface;
use KrisKuiper\Validator\Blueprint\Traits\DecimalTrait;

class Floor extends AbstractMiddleware
{
    use DecimalTrait;

    /**
     * @inheritdoc
     */
    public function handle(MiddlewareFieldInterface $field): void
    {
        $value = $field->getValue();

        if (false === is_numeric($value)) {
            return;
        }

        if (true === is_string($value)) {
            if (true === $this->isDecimal($value)) {
                $value = (string) floor((float) $value);
            } else {
                $value = (string) floor((int) $value);
            }
        } else {
            $value = floor($value);
        }

        $field->setValue($value);
    }
}
