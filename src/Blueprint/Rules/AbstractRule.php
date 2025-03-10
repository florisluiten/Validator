<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Collections\PathCollection;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use KrisKuiper\Validator\Fields\Field;
use KrisKuiper\Validator\Translator\PathTranslator;

abstract class AbstractRule
{
    /**
     * Contains if the rule is bailed or not
     */
    protected bool $bail = false;

    /**
     * Contains the error message
     */
    protected string $message;

    /**
     * Contains all the parameters that the rule needs to validate the value
     */
    private array $parameters = [];

    /**
     * Contains the whole set of data that will be validated
     */
    private PathTranslator $validationData;

    /**
     * Contains the field under validation
     */
    private ?Field $field = null;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->validationData = new PathTranslator();
    }

    /**
     * Returns the name of the rule
     */
    abstract public function getName(): string;

    /**
     * Returns whenever the data under validation is valid or not
     */
    abstract public function isValid(): bool;

    /**
     * Returns the value that needs to be validated
     * @throws ValidatorException
     */
    public function getValue()
    {
        return $this->field?->getValue();
    }

    /**
     * Sets a new parameter that can later be used to validate the value
     */
    public function setParameter($parameterName, $value): void
    {
        $this->parameters[$parameterName] = $value;
    }

    /**
     * Returns the value of a given parameter
     * @throws ValidatorException
     */
    public function getParameter(string $parameterName): mixed
    {
        if (false === array_key_exists($parameterName, $this->parameters)) {
            throw ValidatorException::parameterNotFound($parameterName);
        }

        return $this->parameters[$parameterName];
    }

    public function getValidationData(): PathTranslator
    {
        return $this->validationData;
    }

    public function setValidationData(PathTranslator $validationData): void
    {
        $this->validationData = $validationData;
    }

    public function getField(): ?Field
    {
        return $this->field;
    }

    public function setField(Field $field): void
    {
        $this->field = $field;
    }

    public function getPaths(string|int|float $match): PathCollection
    {
        return $this->validationData->path($match);
    }

    /**
     * Returns if the rule should bail all next rules
     */
    public function shouldBail(): bool
    {
        return $this->bail;
    }

    /**
     * Returns the error message with parsed parameters
     */
    public function getParsedMessage(): ?string
    {
        $message = $this->getRawMessage();

        foreach ($this->getParameters() as $name => $value) {
            if (true === is_array($value)) {
                $value = implode(', ', $value);
            }

            $message = str_replace(':' . $name, (string) $value, $message);
        }

        return $message;
    }

    /**
     * Returns the raw error message without parsed name variables
     */
    public function getRawMessage(): ?string
    {
        return $this->message;
    }

    /**
     * Sets the error message
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    /**
     * Returns all the parameters used for validating this rule
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }
}
