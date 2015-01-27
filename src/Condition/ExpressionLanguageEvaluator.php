<?php

namespace Pragmatist\Regel\Condition;

use Pragmatist\Regel\Context\Context;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

final class ExpressionLanguageEvaluator implements Evaluator
{
    /**
     * @var ExpressionLanguage
     */
    private $expressionLanguage;

    /**
     * @param ExpressionLanguage $expressionLanguage
     */
    public function __construct(ExpressionLanguage $expressionLanguage)
    {
        $this->expressionLanguage = $expressionLanguage;
    }

    /**
     * {@inheritdoc}
     */
    public function evaluate(Condition $condition, Context $context)
    {
        return $this->expressionLanguage->evaluate(
            $condition->getExpression(),
            $context->toArray()
        );
    }
}
