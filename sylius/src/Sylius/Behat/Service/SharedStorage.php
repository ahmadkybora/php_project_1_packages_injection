<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Sylius\Behat\Service;

class SharedStorage implements SharedStorageInterface
{
    /** @var array */
    private $clipboard = [];

    /** @var string|null */
    private $latestKey;

    public function get($key)
    {
        if (!isset($this->clipboard[$key])) {
            throw new \InvalidArgumentException(sprintf('There is no current resource for "%s"!', $key));
        }

        return $this->clipboard[$key];
    }

    public function has($key): bool
    {
        return isset($this->clipboard[$key]);
    }

    public function set($key, $resource): void
    {
        $this->clipboard[$key] = $resource;
        $this->latestKey = $key;
    }

    public function getLatestResource()
    {
        if (!isset($this->clipboard[$this->latestKey])) {
            throw new \InvalidArgumentException(sprintf('There is no "%s" latest resource!', $this->latestKey));
        }

        return $this->clipboard[$this->latestKey];
    }

    public function setClipboard(array $clipboard): void
    {
        $this->clipboard = array_merge($this->clipboard, $clipboard);
    }
}
