<?php

/*
 * Copyright 2011 Johannes M. Schmitt <schmittjoh@gmail.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace JMS\TranslationBundle\Tests\Model;

use JMS\TranslationBundle\Model\Message;

class MessageTest extends \PHPUnit_Framework_TestCase
{
    public function testGetId()
    {
        $message = new Message('foo');
        $this->assertEquals('foo', $message->getId());
    }

    public function testGetDomain()
    {
        $message = new Message('foo', 'bar');
        $this->assertEquals('bar', $message->getDomain());
    }

    public function testGetDesc()
    {
        $message = new Message('foo');
        $this->assertNull($message->getDesc());

        $message->setDesc('foo');
        $this->assertEquals('foo', $message->getDesc());
    }

    public function testGetMeaning()
    {
        $message = new Message('foo');
        $this->assertNull($message->getMeaning());

        $message->setMeaning('foo');
        $this->assertEquals('foo', $message->getMeaning());
    }

    public function testGetSources()
    {
        $message = new Message('foo');
        $this->assertEquals(array(), $message->getSources());

        $message->addSource($source = $this->getMock('JMS\TranslationBundle\Model\SourceInterface'));
        $this->assertSame(array($source), $message->getSources());
    }

    public function testMerge()
    {
        $message = new Message('foo');
        $message->setDesc('foo');
        $message->setMeaning('foo');
        $message->addSource($s1 = $this->getMock('JMS\TranslationBundle\Model\SourceInterface'));

        $message2 = new Message('foo');
        $message2->setDesc('bar');
        $message2->addSource($s2 = $this->getMock('JMS\TranslationBundle\Model\SourceInterface'));

        $message->merge($message2);

        $this->assertEquals('bar', $message->getDesc());
        $this->assertEquals('foo', $message->getMeaning());
        $this->assertSame(array($s1, $s2), $message->getSources());
    }

    public function testToString()
    {
        $message = new Message('foo');
        $this->assertEquals('foo', (string) $message);
    }

    public function hasSource()
    {
        $message = new Message('foo');

        $s2 = $this->getMock('JMS\TranslationBundle\Model\SourceInterface');

        $s1 = $this->getMock('JMS\TranslationBundle\Model\SourceInterface');
        $s1
            ->expects($this->once())
            ->method('equals')
            ->with($s2)
            ->will($this->returnValue(true))
        ;

        $message->addSource($s1);
        $this->assertTrue($message->hasSource($s2));
    }
}