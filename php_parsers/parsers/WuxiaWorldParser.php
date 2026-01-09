<?php

require_once __DIR__ . '/../BaseParser.php';

class WuxiaWorldParser extends BaseParser {
    public function getChapterUrls(DOMDocument $dom) {
        // The chapter list is loaded dynamically, and the API endpoint is not publicly accessible.
        // Returning an empty array as a fallback.
        return [];
    }

    public function findContent(DOMDocument $dom) {
        $xpath = new DOMXPath($dom);
        $nodes = $xpath->query('//div[contains(@class, "fr-view")]');
        $contentNode = null;
        $maxParagraphs = 0;
        foreach ($nodes as $node) {
            $paragraphs = $xpath->query('.//p', $node)->length;
            if ($paragraphs > $maxParagraphs) {
                $maxParagraphs = $paragraphs;
                $contentNode = $node;
            }
        }
        return $contentNode;
    }

    public function extractTitle(DOMDocument $dom) {
        $xpath = new DOMXPath($dom);
        $node = $xpath->query('//h1[contains(@class, "font-set-b24")]')->item(0);
        return $node ? $node->textContent : null;
    }

    public function extractAuthor(DOMDocument $dom) {
        $xpath = new DOMXPath($dom);
        $node = $xpath->query('//div[text()="Author:"]/following-sibling::div')->item(0);
        return $node ? $node->textContent : null;
    }

    public function findCoverImageUrl(DOMDocument $dom) {
        $xpath = new DOMXPath($dom);
        $node = $xpath->query('//img[starts-with(@src, "https://cdn.wuxiaworld.com/images/covers/")]')->item(0);
        return $node ? $node->getAttribute('src') : null;
    }

    public function getInformationEpubItemChildNodes(DOMDocument $dom) {
        $xpath = new DOMXPath($dom);
        $nodes = $xpath->query('//div[contains(@class, "media-novel-index")]//div[contains(@class, "media-body")]|//div[contains(@class, "fr-view")]|//div[contains(@class, "synopsis")]');
        $children = [];
        foreach ($nodes as $node) {
            $children[] = $node;
        }
        return $children;
    }
}
