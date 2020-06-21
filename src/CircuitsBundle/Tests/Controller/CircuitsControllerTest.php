<?php

namespace CircuitsBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CircuitsControllerTest extends WebTestCase
{
    public function testGetcircuits()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/getCircuits');
    }

}
