<?php

/*
 * Opulence
 *
 * @link      https://www.opulencephp.com
 * @copyright Copyright (C) 2017 David Young
 * @license   https://github.com/opulencephp/Opulence/blob/master/LICENSE.md
 */

namespace Opulence\Validation\Tests\Rules;

use Opulence\Validation\Rules\AlphaRule;

/**
 * Tests the alphabetic rule
 */
class AlphaRuleTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Tests that a failing value
     */
    public function testFailingValue() : void
    {
        $rule = new AlphaRule();
        $this->assertFalse($rule->passes(''));
        $this->assertFalse($rule->passes('1'));
        $this->assertFalse($rule->passes('a b'));
    }

    /**
     * Tests getting the slug
     */
    public function testGettingSlug() : void
    {
        $rule = new AlphaRule();
        $this->assertEquals('alpha', $rule->getSlug());
    }

    /**
     * Tests a passing value
     */
    public function testPassingValue() : void
    {
        $rule = new AlphaRule();
        $this->assertTrue($rule->passes('a'));
        $this->assertTrue($rule->passes('abc'));
    }
}
