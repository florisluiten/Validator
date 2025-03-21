<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Exceptions\ValidatorException;

class StartsWith extends AbstractRule
{
    public const NAME = 'startsWith';

    /**
     * @inheritdoc
     */
    protected string $message = 'Value must begin with ":value"';

    /**
     * Constructor
     */
    public function __construct(private string|int|float $value, private bool $caseSensitive = false)
    {
        parent::__construct();
        $this->setParameter('value', $value);
        $this->setParameter('caseSensitive', $caseSensitive);
    }

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
        $value = $this->getValue();

        if (false === is_string($value) && false === is_numeric($value)) {
            return false;
        }

        if (true === $this->caseSensitive) {
            return true === str_starts_with((string) $value, (string) $this->value);
        }

        return true === str_starts_with(strtolower((string) $value), strtolower((string) $this->value));
    }
}
