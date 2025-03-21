<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Exceptions\ValidatorException;

class IsArray extends AbstractRule
{
    public const NAME = 'isArray';

    /**
     * @inheritdoc
     */
    protected string $message = 'Value should be of the type array';

    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return static::NAME;
    }

    /**
     * @inheritdoc
     * @throws ValidatorException
     */
    public function isValid(): bool
    {
        return true === is_array($this->getValue());
    }
}
