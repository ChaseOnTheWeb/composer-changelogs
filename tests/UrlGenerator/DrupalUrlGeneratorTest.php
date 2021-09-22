<?php

/*
 * This file is part of the composer-changelogs project.
 *
 * (c) Loïck Piera <pyrech@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pyrech\ComposerChangelogs\tests\UrlGenerator;

use PHPUnit\Framework\TestCase;
use Pyrech\ComposerChangelogs\UrlGenerator\DrupalUrlGenerator;
use Pyrech\ComposerChangelogs\Version;

class DrupalUrlGeneratorTest extends TestCase
{
    /**
     * @var DrupalUrlGenerator
     */
    private $SUT;

    protected function setUp(): void
    {
        $this->SUT = new DrupalUrlGenerator();
    }

    public function testItSupportsDrupalUrls()
    {
        $this->assertTrue($this->SUT->supports('https://git.drupalcode.org/project/drupal'));
        $this->assertTrue($this->SUT->supports('https://git.drupalcode.org/project/allowed_formats.git'));
        $this->assertTrue($this->SUT->supports('https://git.drupalcode.org/project/coder.git'));
    }

    public function testItDoesNotSupportNonDrupalUrls()
    {
        $this->assertFalse($this->SUT->supports('https://github.com/phpunit/phpunit-mock-objects.git'));
        $this->assertFalse($this->SUT->supports('https://github.com/symfony/console'));
        $this->assertFalse($this->SUT->supports('https://bitbucket.org/mailchimp/mandrill-api-php.git'));
        $this->assertFalse($this->SUT->supports('https://bitbucket.org/rogoOOS/rog'));
    }

    public function testItGeneratesCompareUrls()
    {
        $versionFrom = new Version('1.0.0', '1.0.0', '1.0.0', '1.0.0');
        $versionTo = new Version('1.0.1.0', '1.0.1', '1.0.1', '1.0.1');

        $this->assertSame(
            'https://git.drupalcode.org/project/coder/compare/1.0.0...1.0.1',
            $this->SUT->generateCompareUrl(
                'https://git.drupalcode.org/project/coder.git',
                $versionFrom,
                'https://git.drupalcode.org/project/coder.git',
                $versionTo
            )
        );

        $versionFrom = new Version('1.0.0', '1.0.0', '1.0.0', '8.x-1.0');
        $versionTo = new Version('1.1.0.0', '1.1.0', '1.1.0', '8.x-1.1');

        $this->assertSame(
            'https://git.drupalcode.org/project/coder/compare/1.0.0...1.1.0',
            $this->SUT->generateCompareUrl(
                'https://git.drupalcode.org/project/coder.git',
                $versionFrom,
                'https://git.drupalcode.org/project/coder.git',
                $versionTo
            )
        );
    }

    public function testItGeneratesReleaseUrls()
    {
        $this->assertSame(
            'https://www.drupal.org/project/coder/releases/1.0.1',
            $this->SUT->generateReleaseUrl(
                'https://git.drupalcode.org/project/coder.git',
                new Version('1.0.1.0', '1.0.1', '1.0.1', '1.0.1')
            )
        );

        $this->assertSame(
            'https://www.drupal.org/project/coder/releases/8.x-1.1',
            $this->SUT->generateReleaseUrl(
                'https://git.drupalcode.org/project/coder.git',
                new Version('1.1.0.0', '1.1.0', '1.1.0', '8.x-1.1')
            )
        );
    }
}
