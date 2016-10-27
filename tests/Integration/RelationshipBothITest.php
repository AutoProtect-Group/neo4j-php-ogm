<?php

/*
 * This file is part of the GraphAware Neo4j PHP OGM package.
 *
 * (c) GraphAware Ltd <info@graphaware.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GraphAware\Neo4j\OGM\tests\Integration;

use GraphAware\Neo4j\OGM\Repository\BaseRepository;
use GraphAware\Neo4j\OGM\Tests\Integration\Model\BothRel;
use GraphAware\Neo4j\OGM\Tests\Integration\Model\BothTest;

/**
 * Class RelationshipBothITest.
 *
 * @group rel-both
 */
class RelationshipBothITest extends IntegrationTestCase
{
    /**
     * @group rel-both-proxy
     */

    /*
    public function testBothRelationshipsFetch()
    {
        $this->clearDb();
        $this->createGraph();

        $repository = $this->em->getRepository(BothTest::class);
        $entities = $repository->findAll(['order' => ['name' => BaseRepository::ORDER_ASC]]);
        $this->assertEquals('a', $entities[0]->getName());
        $this->assertEquals('c', $entities[2]->getName());
        $a = $entities[0];
        $this->assertCount(2, $a->getOthers());
        foreach (['c', 'b'] as $i) {
            $this->assertTrue($a->hasOtherWithName($i));
        }
    }
    */

    /**
     * @throws \Exception
     *
     * @group both-x
     */
    public function testBothRelationshipFlush()
    {
        $this->clearDb();
        $other1 = new BothTest('a');
        $other2 = new BothTest('b');
        $other3 = new BothTest('c');
        $other1->addOther($other2);
        $other1->addOther($other3);
        $this->em->persist($other1);
        $this->em->flush();
        $this->assertGraphExist('(b:Both {name:"b"})-[:RELATES]-(a:Both {name:"a"})-[:RELATES]-(c:Both {name:"c"})');
    }

    public function testRelationshipEntityBoth()
    {
        $this->clearDb();
        $b1 = new BothTest('a');
        $b2 = new BothTest('b');
        $b3 = new BothTest('c');
        $b1->addFriend($b2);
        $b1->addFriend($b3);
        $this->em->persist($b1);
        $this->em->flush();
        $this->assertGraphExist('(b:Both {name:"b"})-[:FRIEND]-(a:Both {name:"a"})-[:FRIEND]-(c:Both {name:"c"})');
        $this->em->clear();
        $repository = $this->em->getRepository(BothTest::class);
        $entities = $repository->findAll(['order' => ['name' => BaseRepository::ORDER_ASC]]);
        $this->assertEquals('a', $entities[0]->getName());
        $this->assertEquals('c', $entities[2]->getName());
        $a = $entities[0];
        $this->assertCount(2, $a->getFriends());
        foreach ($a->getFriends() as $friend) {
            $this->assertInstanceOf(BothRel::class, $friend);
            $this->assertTrue(in_array($friend->getEndNode()->getName(), ['b', 'c'], true));
        }
    }

    private function createGraph()
    {
        $query = 'CREATE (a:Both {name:"a"})-[:RELATES]->(b:Both {name:"b"}), (a)<-[:RELATES]-(c:Both {name:"c"})';
        $this->client->run($query);
    }
}
