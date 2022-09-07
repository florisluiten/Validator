<?php

declare(strict_types=1);

namespace tests\unit\Middleware;

use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use PHPUnit\Framework\TestCase;

final class RTrimTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testShouldPassValidationWhenUsingSimpleFieldValue(): void
    {
        $data = ['field' => ' foo '];

        $validator = new Validator($data);
        $validator->middleware('field')->rtrim();
        $validator->field('field')->equals(' foo', true);

        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testShouldRetrieveCorrectValidatedDataWhenUsingThreeDimensionalArrayValues(): void
    {
        $data = ['options' => [0, 1, true, false, '', null, [], (object) [], 2552, [1, 2], ['a', 'b'], ['foo' => 'bar']]];

        $validator = new Validator($data);
        $validator->middleware('options.*')->rtrim();

        $this->assertTrue($validator->execute());
        $this->assertEquals(['options' => [0, 1, true, false, '', null, [], (object) [], 2552, [1, 2], ['a', 'b'], ['foo' => 'bar']]], $validator->validatedData()->toArray());
    }

    /**
     * @throws ValidatorException
     */
    public function testShouldPassValidationWhenUsingDifferentCharacters(): void
    {
        $data = ['field' => '--foo__'];

        $validator = new Validator($data);
        $validator->middleware('field')->rtrim('-_');
        $validator->field('field')->equals('--foo', true);

        $this->assertTrue($validator->execute());
    }
}
