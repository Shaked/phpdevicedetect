## Device Detect Package for PHP

This package contains the ability to detect different devices by it's user agent.

### Status: not stable yet!

### Installation

```
$ composer install
```

### Usage

```
<?php
require_once "../vendor/autoload.php";
$userAgent = $_SERVER["HTTP_USER_AGENT"];
try {
    $deviceDetect = DeviceDetect::fromUserAgent($userAgent);
    echo "<pre>";
    print_r([
        "isMobile"  => (int) $deviceDetect->isMobile(),
        "isTablet"  => (int) $deviceDetect->isTablet(),
        "isDesktop" => (int) $deviceDetect->isDesktop(),
        "isTv"      => (int) $deviceDetect->isTv(),
        "isWatch"   => (int) $deviceDetect->isWatch(),
        "isBot"     => (int) $deviceDetect->isBot(),
        "isUnknown" => (int) $deviceDetect->isUnknown(),
    ]);
} catch (\InvalidArgumentException $e) {
    echo $e->getMessage();
}
```

### Contribute

If you wish to contribute, please just make sure that if its user agent related, you should add it to the [user agent repository](https://github.com/Shaked/user-agents).