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
        "isGlass"   => (int) $deviceDetect->isGlass(),
        "isUnknown" => (int) $deviceDetect->isUnknown(),
    ]);
} catch (\InvalidArgumentException $e) {
    echo $e->getMessage();
}