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
        $options = [
            'http' => [
                'method' => 'GET',
                'header' => "User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/100.0.4896.127 Safari/537.36\r\n"
            ]
        ];
        $context = stream_context_create($options);
        $html = file_get_contents($url, false, $context);
        if ($html === false) {
            throw new Exception("Failed to fetch URL: " . $url);
        }
        libxml_use_internal_errors(true);
        $dom = new DOMDocument();
        $dom->loadHTML($html);
        $errors = libxml_get_errors();
        if (!empty($errors)) {
            print_r($errors);
        }
        libxml_clear_errors();
        return $dom;
    }
}
