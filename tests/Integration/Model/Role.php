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
 * @OGM\RelationshipEntity(type="ACTED_IN")
 */
class Role
{
    /**
     * @OGM\GraphId()
     */
    protected $id;

    /**
     * @OGM\StartNode(targetEntity="Person")
     */
    protected $actor;

    /**
     * @OGM\EndNode(targetEntity="Movie")
     */
    protected $movie;

    /**
     * @OGM\Property(type="array")
     */
    protected $roles;

    public function __construct(Person $actor, Movie $movie, $roles = null)
    {
        $this->actor = $actor;
        $this->movie = $movie;
        if (is_array($roles)) {
            $this->roles = $roles;
        }
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getActor()
    {
        return $this->actor;
    }

    /**
     * @return mixed
     */
    public function getMovie()
    {
        return $this->movie;
    }

    /**
     * @return mixed
     */
    public function getRoles()
    {
        return $this->roles;
    }

    public function setRoles(array $roles)
    {
        $this->roles = $roles;
    }
}
