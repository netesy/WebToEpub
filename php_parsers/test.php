<?php

require_once __DIR__ . '/ParserFactory.php';

$urls = [
    'https://www.wuxiaworld.com/novel/a-will-eternal',
];

foreach ($urls as $url) {
    try {
        echo "Testing URL: $url\n";
        $parser = ParserFactory::create($url);
        $dom = $parser->getDom($url);

        $title = $parser->extractTitle($dom);
        echo "Title: $title\n";

        $author = $parser->extractAuthor($dom);
        echo "Author: $author\n";

        $coverUrl = $parser->findCoverImageUrl($dom);
        echo "Cover URL: $coverUrl\n";

        $chapters = $parser->getChapterUrls($dom);
        echo "Found " . count($chapters) . " chapters.\n";
        if (count($chapters) > 0) {
            echo "First chapter: " . $chapters[0]['title'] . " - " . $chapters[0]['sourceUrl'] . "\n";
        }

        echo "\n";
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n\n";
    }
}
