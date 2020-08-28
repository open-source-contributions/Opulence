<?php

/*
 * Opulence
 *
 * @link      https://www.opulencephp.com
 * @copyright Copyright (C) 2017 David Young
 * @license   https://github.com/opulencephp/Opulence/blob/master/LICENSE.md
 */

namespace Opulence\Console\Tests\Responses\Compilers\Lexers\Tokens;

use Opulence\Console\Responses\Compilers\Lexers\Tokens\Token;
use Opulence\Console\Responses\Compilers\Lexers\Tokens\TokenTypes;

/**
 * Tests the response token
 */
class TokenTest extends \PHPUnit\Framework\TestCase
{
    /** @var Token The token to use in tests */
    private $token = null;

    /**
     * Sets up the tests
     */
    public function setUp()
    {
        $this->token = new Token(TokenTypes::T_WORD, 'foo', 24);
    }

    /**
     * Tests getting the position
     */
    public function testGettingPosition()
    {
        $this->assertSame(24, $this->token->getPosition());
    }

    /**
     * Tests getting the type
     */
    public function testGettingType()
    {
        $this->assertSame(TokenTypes::T_WORD, $this->token->getType());
    }

    /**
     * Tests getting the value
     */
    public function testGettingValue()
    {
        $this->assertSame('foo', $this->token->getValue());
    }
}