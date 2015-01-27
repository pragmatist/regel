<?php

namespace Pragmatist\Regel\Condition;

use Pragmatist\Regel\Subject\Subject;
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
    public function evaluate(Condition $condition, Subject $subject)
    {
        return $this->expressionLanguage->evaluate(
            $condition->getExpression(),
            $subject->toArray()
        );
    }
}
