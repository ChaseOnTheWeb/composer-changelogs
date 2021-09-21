<?php

/*
 * This file is part of the composer-changelogs project.
 *
 * (c) Loïck Piera <pyrech@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pyrech\ComposerChangelogs\UrlGenerator;

use Pyrech\ComposerChangelogs\Version;

class DrupalUrlGenerator extends GitlabUrlGenerator
{
    public const GITLAB_DOMAIN = 'git.drupalcode.org';

    public const DRUPAL_URL = 'www.drupal.org';

    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        parent::__construct(self::GITLAB_DOMAIN);
    }

    /**
     * {@inheritdoc}
     */
    public function generateReleaseUrl($sourceUrl, Version $version)
    {
        $projectBaseUrl = parse_url($this->generateBaseUrl($sourceUrl));
        $projectBaseUrl['host'] = self::DRUPAL_URL;

        return sprintf(
          '%s://%s%s/releases/%s',
          $projectBaseUrl['scheme'],
          $projectBaseUrl['host'],
          $projectBaseUrl['path'],
          $version->getDistReference()
        );
    }
}
