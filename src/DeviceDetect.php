<?php
# The MIT License (MIT)
#
# Copyright (c) 2015 Shaked Klein Orbach
#
# Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
#
# The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
#
# THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

class DeviceDetect {

    /**
     * @var mixed
     */
    private $meta;
    /**
     * @var array<Browser>
     */
    private $browsers;
    /**
     * @var Platform
     */
    private $platform;

    /**
     * @var array
     */
    static private $compiledUserAgents;

    /**
     * @param stdClass $meta
     */
    public function __construct(stdClass $meta) {
        $this->meta = $meta;
    }

    /**
     * @param string $userAgent
     * @throws \InvalidArgumentException
     */
    public static function fromUserAgent($userAgent) {
        if (empty(self::$compiledUserAgents)) {
            self::$compiledUserAgents = require_once __DIR__ . "/../vendor/Shaked/user-agents/compiled-user-agents.php";
        }
        $compiledUserAgents = self::$compiledUserAgents;

        $hash = self::getHashedUserAgent($userAgent, $compiledUserAgents["meta"]["hash"]);
        if (!isset($compiledUserAgents["userAgents"][$hash])) {
            throw new \InvalidArgumentException("User agent $userAgent is unknown. Please update user-agents repository for future support");
        }

        $meta = (object) $compiledUserAgents["userAgents"][$hash];
        return new self($meta);
    }

    /**
     * @param $userAgent
     * @param $hashFunc
     */
    private static function getHashedUserAgent($userAgent, $hashFunc) {
        switch ($hashFunc) {
        case "crc32b":
            return crc32($userAgent);
            break;
        }

        throw new \InvalidArgumentException("Invalid hashing function: $hashFunc");
    }

    /**
     * @todo should isTablet() return true for isMobile?
     * @return bool
     */
    public function isMobile() {
        return $this->meta->type == "mobile";
    }

    /**
     * @return bool
     */
    public function isTablet() {
        return $this->meta->type == "tablet";
    }

    /**
     * @return bool
     */
    public function isDesktop() {
        return $this->meta->type == "desktop";
    }

    /**
     * @return bool
     */
    public function isTv() {
        return $this->meta->type == "tv";
    }

    /**
     * @return bool
     */
    public function isWatch() {
        return $this->meta->type == "watch";
    }

    /**
     * @return bool
     */
    public function isBot() {
        return $this->meta->type == "bot";
    }

    /**
     * @todo  check if this make sense
     * @return bool
     */
    public function isUnknown() {
        return !$this->meta->type;
    }

    /**
     * @return array
     */
    public function getBrowsers() {
        if (empty($this->browsers)) {
            $browsers = (isset($this->browser)) ? [$this->browser] : $this->meta->browsers;
            foreach ($browsers as $browser) {
                $this->browsers[] = new Browser(
                    $browser["name"],
                    $browser["version"]
                );
            }
        }
        return $this->browsers;
    }

    /**
     * @return Platform
     */
    public function getPlatform() {
        if (empty($this->platform)) {
            $this->platform = Platform::from(
                $this->meta->type,
                (object) $this->meta->platform
            );
        }
        return $this->platform;
    }

    /**
     * @return string
     */
    public function getUserAgent() {
        return $this->meta->name;
    }
}
