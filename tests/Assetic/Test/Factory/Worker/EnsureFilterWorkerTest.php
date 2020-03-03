<?php

/*
 * This file is part of the Assetic package, an OpenSky project.
 *
 * (c) 2010-2014 OpenSky Project Inc
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Assetic\Test\Factory\Worker;

use Assetic\Factory\Worker\EnsureFilterWorker;
use Assetic\Test\TestCase;

class EnsureFilterWorkerTest extends TestCase
{
    public function testMatch()
    {
        $filter = $this->getMockBuilder('Assetic\\Filter\\FilterInterface')->getMock();
        $asset = $this->getMockBuilder('Assetic\\Asset\\AssetInterface')->getMock();
        $factory = $this->getMockBuilder('Assetic\Factory\AssetFactory')
            ->disableOriginalConstructor()
            ->getMock();

        $asset->expects($this->once())
            ->method('getTargetPath')
            ->will($this->returnValue('css/main.css'));
        $asset->expects($this->once())
            ->method('ensureFilter')
            ->with($filter);

        $worker = new EnsureFilterWorker('/\.css$/', $filter);
        $worker->process($asset, $factory);
    }

    public function testNonMatch()
    {
        $filter = $this->getMockBuilder('Assetic\\Filter\\FilterInterface')->getMock();
        $asset = $this->getMockBuilder('Assetic\\Asset\\AssetInterface')->getMock();
        $factory = $this->getMockBuilder('Assetic\Factory\AssetFactory')
            ->disableOriginalConstructor()
            ->getMock();

        $asset->expects($this->once())
            ->method('getTargetPath')
            ->will($this->returnValue('js/all.js'));
        $asset->expects($this->never())->method('ensureFilter');

        $worker = new EnsureFilterWorker('/\.css$/', $filter);
        $worker->process($asset, $factory);
    }
}
