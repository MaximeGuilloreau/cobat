<?php

namespace AppBundle\Security;

use AppBundle\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;

class UserFactory
{
    private $jwtEncoder;

    public function __construct(JWTEncoderInterface $JWTEncoder)
    {
        $this->jwtEncoder = $JWTEncoder;
    }

    public function createFromToken($token)
    {
        $jwtData = $this->jwtEncoder->decode($token);

        $userJwt = new User();
        $userJwt->setRoles(['ROLE_USER']);
        $userJwt->setUsername($jwtData['username']);

        return $userJwt;
    }
}
