<?php

abstract class BaseParser {
    protected $url;

    public function __construct($url) {
        $this->url = $url;
    }

    abstract public function getChapterUrls(DOMDocument $dom);
    abstract public function findContent(DOMDocument $dom);
    abstract public function extractTitle(DOMDocument $dom);
    abstract public function extractAuthor(DOMDocument $dom);
    abstract public function findCoverImageUrl(DOMDocument $dom);
    abstract public function getInformationEpubItemChildNodes(DOMDocument $dom);

    public function getDom($url) {
        $command = "node get_rendered_html.js " . escapeshellarg($url);
        $html = shell_exec($command);
        if ($html === null) {
            throw new Exception("Failed to fetch URL using headless browser: " . $url);
        }
        libxml_use_internal_errors(true);
        $dom = new DOMDocument();
        $dom->loadHTML('<?xml encoding="utf-8" ?>' . $html);
        $errors = libxml_get_errors();
        if (!empty($errors)) {
            print_r($errors);
        }
        libxml_clear_errors();
        return $dom;
    }
}
