<?php

declare(strict_types=1);

namespace tests\unit\Rules;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class IsAlphaDashTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenOnlyAlphaDashValuesAreProvided(): void
    {
        foreach (['abcdefg', 'ABCDEFG', 'AbCdEfG', 'abcd_', 'AbC__dEf_G'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->isAlphaDash();
            $validator->execute();
            $this->assertTrue($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenNonAlphaDashValuesAreProvided(): void
    {
        foreach ([null, [], (object) [], 2552, true, '2817334', 'abcd123'] as $data) {
            $validator = new Validator(['field' => $data]);
            $validator->field('field')->isAlphaDash();
            $this->assertFalse($validator->execute());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectErrorMessageIsReturnedWhenCustomMessageIsSet(): void
    {
        $validator = new Validator(['field' => '']);
        $validator->field('field')->isAlphaDash();
        $validator->messages('field')->isAlphaDash('Message alpha dash');
        $this->assertFalse($validator->execute());
        $this->assertSame('Message alpha dash', $validator->errors()->first('field')->getMessage());
    }
}
