<?php
/**
 * Opulence
 *
 * @link      https://www.opulencephp.com
 * @copyright Copyright (C) 2016 David Young
 * @license   https://github.com/opulencephp/Opulence/blob/master/LICENSE.md
 */
namespace Opulence\Authentication\Tokens\JsonWebTokens\Verification;

use Opulence\Authentication\Tokens\JsonWebTokens\SignedJwt;
use Opulence\Authentication\Tokens\JsonWebTokens\JwtPayload;

/**
 * Tests the audience verifier
 */
class AudienceVerifierTest extends \PHPUnit_Framework_TestCase
{
    /** @var SignedJwt|\PHPUnit_Framework_MockObject_MockObject The token to use in tests */
    private $jwt = null;
    /** @var JwtPayload|\PHPUnit_Framework_MockObject_MockObject The payload to use in tests */
    private $jwtPayload = null;

    /**
     * Sets up the tests
     */
    public function setUp()
    {
        $this->jwt = $this->getMock(SignedJwt::class, [], [], "", false);
        $this->jwtPayload = $this->getMock(JwtPayload::class);
        $this->jwt->expects($this->any())
            ->method("getPayload")
            ->willReturn($this->jwtPayload);
    }

    /**
     * Tests that an exception is thrown on a mismatching array audience
     */
    public function testExceptionThrownOnMismatchingArray()
    {
        $this->setExpectedException(VerificationException::class);
        $verifier = new AudienceVerifier("foo");
        $this->jwtPayload->expects($this->once())
            ->method("getAudience")
            ->willReturn("bar");
        $verifier->verify($this->jwt);
    }

    /**
     * Tests that an exception is thrown on a mismatching string audience
     */
    public function testExceptionThrownOnMismatchingString()
    {
        $this->setExpectedException(VerificationException::class);
        $verifier = new AudienceVerifier("foo");
        $this->jwtPayload->expects($this->once())
            ->method("getAudience")
            ->willReturn("bar");
        $verifier->verify($this->jwt);
    }

    /**
     * Tests verifying against an empty audience is successful
     */
    public function testVerifyingEmptyAudienceIsSuccessful()
    {
        $verifier = new AudienceVerifier([]);
        $this->jwtPayload->expects($this->once())
            ->method("getAudience")
            ->willReturn("bar");
        $verifier->verify($this->jwt);
    }

    /**
     * Tests verifying valid array audience
     */
    public function testVerifyingValidArrayAudience()
    {
        $verifier = new AudienceVerifier(["foo", "bar"]);
        $this->jwtPayload->expects($this->once())
            ->method("getAudience")
            ->willReturn(["bar", "baz"]);
        $verifier->verify($this->jwt);
    }

    /**
     * Tests verifying valid string audience
     */
    public function testVerifyingValidStringAudience()
    {
        $verifier = new AudienceVerifier("foo");
        $this->jwtPayload->expects($this->once())
            ->method("getAudience")
            ->willReturn("foo");
        $verifier->verify($this->jwt);
    }
}