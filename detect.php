<?php
$userAgent = $_SERVER["HTTP_USER_AGENT"];
$compiledUserAgents = require_once "vendor/Shaked/user-agents/compiled-user-agents.php";
$compiledPriorityUserAgents = require_once "vendor/Shaked/user-agents/compiled-priority-user-agents.php";

$hash = hexdec(hash($compiledUserAgents["meta"]["hash"], $userAgent));
if (isset($compiledUserAgents["userAgents"][$hash])) {
    $meta = (object) $compiledUserAgents["userAgents"][$hash];
    $deviceDetect = new DeviceDetect($meta);
    var_dump(
        $deviceDetect->isMobile(),
        $deviceDetect->isTablet(),
        $deviceDetect->isDesktop(),
        $deviceDetect->isTv(),
        $deviceDetect->isWatch(),
        $deviceDetect->isBot()
    );
} else {
    echo "user agent $userAgent doesn't exist, hash: $hash";
}

class DeviceDetect {

    private $meta;
    private $browsers;
    private $platform;

    public function __construct(stdClass $meta) {
        $this->meta = $meta;
    }

    public function isMobile() {
        return $this->meta->type == "mobile" || $this->isTablet();
    }

    public function isTablet() {
        return $this->meta->type == "tablet";
    }

    public function isDesktop() {
        return $this->meta->type == "desktop";
    }

    public function isTv() {
        return $this->meta->type == "tv";
    }

    public function isWatch() {
        return $this->meta->type == "watch";
    }

    public function isBot() {
        return $this->meta->type == "bot";
    }

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

    public function getPlatform() {
        if (empty($this->platform)) {
            $this->platform = Platform::form(
                $this->meta->type,
                $this->meta->platform
            );
        }
        return $this->platform;
    }

    public function getUserAgent() {
        return $this->meta->name;
    }
}

class Browser {
    private $name;
    private $version;

    public function __construct($name, $version) {
        $this->name = $name;
        $this->version = $version;
    }

    public function getName() {
        return $this->name;
    }

    public function getVersion() {
        return $this->version;
    }
}
abstract class Platform {
    protected $name;
    protected $version;

    public function __construct($name, $version) {
        $this->name = $name;
        $this->version = $version;
    }

    public function getName() {
        return $this->name;
    }

    public function getVersion() {
        return $this->version;
    }

    public static function from($type, stdClass $platformInfo) {
        switch ($type) {
        case "mobile":
            return new Mobile(
                $platformInfo->name,
                $platformInfo->version,
                $platformInfo->model,
                $platformInfo->build
            );
        case "tablet":
            return new Tablet(
                $platformInfo->name,
                $platformInfo->version,
                $platformInfo->model,
                $platformInfo->build
            );
        case "desktop":
            return new Desktop(
                $platformInfo->name,
                $platformInfo->version,
                $platformInfo->model,
                $platformInfo->build
            );
        case "tv":
            return new Tv(
                $platformInfo->name,
                $platformInfo->version
            );
        case "watch":
            return new Watch(
                $platformInfo->name,
                $platformInfo->version
            );
        case "bot":
            return new Bot(
                $platformInfo->name,
                $platformInfo->version
            );
        default:
            return new Unknown(
                $platformInfo->name,
                $platformInfo->version
            );
        }
    }
}

class Mobile extends Platform {
    private $model;
    private $build;
    public function __construct($name, $version, $model, $build) {
        parent::__construct($name, $version);
        $this->model = $model;
        $this->build = $build;
    }
    public function getModel() {
        return $this->meta->model;
    }

    public function getBuild() {
        return $this->meta->build;
    }
}

class Tablet extends Platform {
    private $model;
    private $build;
    public function __construct($name, $version, $model, $build) {
        parent::__construct($name, $version);
        $this->model = $model;
        $this->build = $build;
    }
    public function getModel() {
        return $this->meta->model;
    }

    public function getBuild() {
        return $this->meta->build;
    }
}

class Desktop extends Platform {

}

class Unkown extends Desktop {

}

class Tv extends Platform {

}

class Bot extends Platform {

}

class Watch extends Platform {

}