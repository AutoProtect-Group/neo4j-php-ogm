<?php

/*
 * This file is part of the GraphAware Neo4j PHP OGM package.
 *
 * (c) GraphAware Ltd <info@graphaware.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GraphAware\Neo4j\OGM\tests\Integration\NativeQuery;

use GraphAware\Neo4j\OGM\Tests\Integration\IntegrationTestCase;
use GraphAware\Neo4j\OGM\Tests\Integration\NativeQuery\Model\NewsFeed;
use GraphAware\Neo4j\OGM\Tests\Integration\NativeQuery\Model\Post;
use GraphAware\Neo4j\OGM\Tests\Integration\NativeQuery\Model\PostRepository;
use GraphAware\Neo4j\OGM\Tests\Integration\NativeQuery\Model\User;

/**
 * @group query-result-it
 */
class QueryResultMappingITTest extends IntegrationTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->clearDb();
    }

    public function testNativeQueryResultMapping()
    {
        $this->createGraph();
        /** @var PostRepository $repository */
        $repository = $this->em->getRepository(Post::class);
        $this->assertInstanceOf(PostRepository::class, $repository);

        /** @var NewsFeed[] $result */
        $feeds = $repository->getNewsFeed();
        foreach ($feeds as $feed) {
            $this->assertInstanceOf(NewsFeed::class, $feed);
        }
        $this->assertEquals('Graph Aided Search', $feeds[0]->getPost()->getTitle());
    }

    public function testNativeQueryResultWithAndOr()
    {
        $this->clearDb();
        $user = new User('johndoe', 'john@doe.com');
        $this->em->persist($user);
        $this->em->flush();
        $this->em->clear();
    }

    private function createGraph()
    {
        $query = 'CREATE (p:Post {title:"Graph Aided Search"}), (p2:Post {title:"Use SDN4 like a superhero!"})';
        $this->client->run($query);
    }
}
