<?php

/**
 * This file is part of Gitonomy.
 *
 * (c) Alexandre Salomé <alexandre.salome@gmail.com>
 * (c) Julien DIDIER <genzo.wm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Gitonomy\Git\Tests;

class LogTest extends AbstractTest
{
    /**
     * @dataProvider provideFoobar
     */
    public function testRevisionAndPath($repository)
    {
        $logReadme = $repository->getLog(self::LONGFILE_COMMIT, 'README');
        $logImage = $repository->getLog(self::LONGFILE_COMMIT, 'image.jpg');

        $this->assertCount(3, $logReadme);
        $this->assertCount(2, $logImage);
    }

    /**
     * @dataProvider provideFoobar
     */
    public function testGetCommits($repository)
    {
        $log = $repository->getLog(self::LONGFILE_COMMIT, null, null, 3);

        $commits = $log->getCommits();

        $this->assertCount(3, $commits, '3 commits in log');
        $this->assertEquals(self::LONGFILE_COMMIT, $commits[0]->getHash(), 'First is requested one');
        $this->assertEquals(self::BEFORE_LONGFILE_COMMIT, $commits[1]->getHash(), "Second is longfile parent\'s");
    }

    /**
     * @dataProvider provideFoobar
     */
    public function testCountCommits($repository)
    {
        $log = $repository->getLog(self::LONGFILE_COMMIT, null, 2, 3);

        $this->assertEquals(8, $log->countCommits(), '8 commits found in history');
    }

    /**
     * @dataProvider provideFoobar
     */
    public function testCountAllCommits($repository)
    {
        $log = $log = $repository->getLog();

        $this->assertGreaterThan(100, $log->countCommits(), 'Returns all commits from all branches');
    }

    /**
     * @dataProvider provideFoobar
     */
    public function testIterable($repository)
    {
        $log = $repository->getLog(self::LONGFILE_COMMIT);

        $expectedHashes = [self::LONGFILE_COMMIT, self::BEFORE_LONGFILE_COMMIT];
        foreach ($log as $entry) {
            $hash = array_shift($expectedHashes);
            $this->assertEquals($hash, $entry->getHash());
            if (count($expectedHashes) == 0) {
                break;
            }
        }
    }

    public function testFirstMessageEmpty()
    {
        $repository = $this->createEmptyRepository(false);
        $repository->run('config', ['--local', 'user.name', '"Unit Test"']);
        $repository->run('config', ['--local', 'user.email', '"unit_test@unit-test.com"']);

        // Edge case: first commit lacks a message.
        file_put_contents($repository->getWorkingDir().'/file', 'foo');
        $repository->run('add', ['.']);
        $repository->run('commit', ['--allow-empty-message', '--no-edit']);

        $commits = $repository->getLog()->getCommits();
        $this->assertCount(1, $commits);
    }
}
