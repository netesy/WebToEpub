<?php

require_once __DIR__ . '/parsers/WuxiaWorldParser.php';

class ParserFactory {
    public static function create($url) {
        $host = parse_url($url, PHP_URL_HOST);

        switch ($host) {
            case 'wuxiaworld.com':
            case 'www.wuxiaworld.com':
                return new WuxiaWorldParser($url);
            default:
                throw new Exception("No parser found for host: " . $host);
        }
    }
}
