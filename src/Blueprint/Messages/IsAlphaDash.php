<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\IsAlphaDash as IsAlphaDashRule;

class IsAlphaDash extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return IsAlphaDashRule::NAME;
    }
}
