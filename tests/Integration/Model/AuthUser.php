<?php

/*
 * This file is part of the GraphAware Neo4j PHP OGM package.
 *
 * (c) GraphAware Ltd <info@graphaware.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GraphAware\Neo4j\OGM\tests\Integration\Model;

use GraphAware\Neo4j\OGM\Annotations as OGM;

/**
 * @OGM\Node(label="User")
 */
class AuthUser
{
    /**
     * @OGM\GraphID
     *
     * @var int
     */
    protected $id;

    /**
     * @OGM\Property(type="string")
     *
     * @var string
     */
    protected $username;

    /**
     * @OGM\Property(type="string")
     *
     * @var string
     */
    protected $password;

    /*
     * @param string $username
     * @param string $password
     */
    public function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    /*
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /*
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /*
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }
}
