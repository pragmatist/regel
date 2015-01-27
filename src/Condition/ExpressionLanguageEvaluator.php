<?php

namespace Pragmatist\Regel\Condition;

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
    public function evaluate(Condition $condition, $subject)
    {
        return (bool) $this->expressionLanguage->evaluate(
            $condition->getExpression(),
            ['subject' => $subject]
        );
    }
}
