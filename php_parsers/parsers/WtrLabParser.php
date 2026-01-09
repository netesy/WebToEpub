<?php

require_once __DIR__ . '/../BaseParser.php';

class WtrLabParser extends BaseParser {
    public function getChapterUrls(DOMDocument $dom) {
        $xpath = new DOMXPath($dom);
        $chapterNodes = $xpath->query('//div[contains(@class, "accordion-body")]//a');
        $chapters = [];
        foreach ($chapterNodes as $node) {
            $chapters[] = [
                'sourceUrl' => 'https://wtr-lab.com' . $node->getAttribute('href'),
                'title' => $node->textContent
            ];
        }
        return $chapters;
    }

    public function findContent(DOMDocument $dom) {
        $xpath = new DOMXPath($dom);
        $node = $xpath->query('//div[contains(@class, "content")]')->item(0);
        return $node;
    }

    public function extractTitle(DOMDocument $dom) {
        $xpath = new DOMXPath($dom);
        $node = $xpath->query('//h1[contains(@class, "long-title")]')->item(0);
        return $node ? $node->textContent : null;
    }

    public function extractAuthor(DOMDocument $dom) {
        $xpath = new DOMXPath($dom);
        $node = $xpath->query('//a[starts-with(@href, "/en/author/")]')->item(0);
        return $node ? $node->textContent : null;
    }

    public function findCoverImageUrl(DOMDocument $dom) {
        $xpath = new DOMXPath($dom);
        $node = $xpath->query('//div[contains(@class, "image-wrap")]//img')->item(0);
        if ($node) {
            $src = $node->getAttribute('src');
            if (strpos($src, 'http') !== 0) {
                return 'https://wtr-lab.com' . $src;
            }
            return $src;
        }
        return null;
    }

    public function getInformationEpubItemChildNodes(DOMDocument $dom) {
        $xpath = new DOMXPath($dom);
        $nodes = $xpath->query('//span[contains(@class, "description")]');
        $children = [];
        foreach ($nodes as $node) {
            $children[] = $node;
        }
        return $children;
    }
}
