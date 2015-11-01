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

abstract class Platform {
    /**
     * @var string
     */
    protected $name;
    /**
     * @var string
     */
    protected $version;

    /**
     * @param $name
     * @param $version
     */
    public function __construct($name, $version) {
        $this->name = $name;
        $this->version = $version;
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getVersion() {
        return $this->version;
    }

    /**
     * @param $type
     * @param stdClass $platformInfo
     * @return Platform
     */
    public static function from($type, stdClass $platformInfo) {
        switch ($type) {
        case "mobile":
            return new Platform\Mobile(
                $platformInfo->name,
                $platformInfo->version,
                $platformInfo->model,
                $platformInfo->build
            );
        case "tablet":
            return new Platform\Tablet(
                $platformInfo->name,
                $platformInfo->version,
                $platformInfo->model,
                $platformInfo->build
            );
        case "desktop":
            return new Platform\Desktop(
                $platformInfo->name,
                $platformInfo->version
            );
        case "tv":
            return new Platform\Tv(
                $platformInfo->name,
                $platformInfo->version
            );
        case "watch":
            return new Platform\Watch(
                $platformInfo->name,
                $platformInfo->version
            );
        case "bot":
            return new Platform\Bot(
                $platformInfo->name,
                $platformInfo->version
            );
        default:
            return new Platform\Unknown(
                $platformInfo->name,
                $platformInfo->version
            );
        }
    }
}