<?php

namespace Pragmatist\Regel\Condition;

use Symfony\Component\ExpressionLanguage\Expression;

final class ExpressionLanguageCondition implements Condition
{
    /**
     * @var Expression
     */
    private $expression;

    /**
     * @param string $expression
     * @return ExpressionLanguageCondition
     */
    public static function fromString($expression)
    {
        return new ExpressionLanguageCondition(
            new Expression($expression)
        );
    }

    /**
     * @param Expression $expression
     */
    public function __construct(Expression $expression)
    {
        $this->expression = $expression;
    }

    /**
     * @return Expression
     */
    public function getExpression()
    {
        return $this->expression;
    }
}
