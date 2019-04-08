<?php

namespace App\Utils;

class MarkdownTableOfContents
{
    protected $markdown = '';
    protected $basicUrl = '';
    protected $headings = [];
    protected $anchors  = [];
    public function __construct(string $markdown, string $basicUrl)
    {
        $this->markdown = $markdown;
        $this->basicUrl = $basicUrl;
    }

    protected function stringToStream(string $markdown)
    {
        $stream = fopen('php://temp', 'rb+');
        fwrite($stream, $markdown);
        rewind($stream);
        return $stream;
    }
    public function process(): string
    {
        $body = $this->buildLinkedMarkdown();
        $toc  = $this->buildTableOfContents();
        return $toc ;
    }
    protected function buildLinkedMarkdown()
    {
        $markdown = '';
        $codeFlag = false;
        $stream   = $this->stringToStream($this->markdown);
        while ($line = fgets($stream)) {
            if(strpos($line, '```') != false || $codeFlag){
                $codeFlag = !$codeFlag;
                continue;
            }
            if (
                false !== strpos($line, '#') &&
                preg_match('/^(?P<prespace>\s+)?(?P<level>#{1,6})(?P<title>.*)(?P<postspace>\s+)?$/', $line, $matches) &&
                isset($matches['level'], $matches['title'])
            ) {
                $anchor = $this->getAnchorSlug($matches['title']);
                $this->headings[] = [
                    'level'  => strlen($matches['level']),
                    'title'  => $matches['title'],
                    'anchor' => $anchor,
                ];
                $markdown .= sprintf(
                    '%s%s <a name="%s" id="%s">%s</a>%s',
                    $matches['prespace'] ?? '',
                    $matches['level'],
                    $anchor,
                    $anchor,
                    trim($matches['title']),
                    $matches['postspace'] ?? ''
                );
            } else {
                $markdown .= $line;
            }
        }
        return $markdown;
    }
    protected function getAnchorSlug(string $string): string
    {
        $anchor = str_slug(trim($string));
        if (isset($this->anchors[$anchor])) {
            $this->anchors[$anchor] = ($this->anchors[$anchor] + 1);
            $anchor .= '-' . $this->anchors[$anchor];
        } else {
            $this->anchors[$anchor] = 1;
        }
        return $anchor;
    }
    protected function buildTableOfContents(): string
    {
        if (count($this->headings) === 0) {
            return '';
        }
        $markdown = '# Contents' . "\n";
        foreach ($this->headings as $heading) {
            $markdown .= sprintf(
                '%s [%s](%s#%s)' . "\n",
                str_repeat('    ', $heading['level'] - 1) . '*',
                $this->removeMarkdownLink(trim($heading['title'])),
                $this->basicUrl,
                $this->getTitleSlug($heading['title'])
            );
        }
        return $markdown;
    }

    protected function removeMarkdownLink(string $string): string
    {
        preg_match('/\[(.*)\]\((.*)\)/', $string, $matches);
        if(count($matches) == 3){
            return $matches[1];
        }
        return $string;
    }

    protected function getTitleSlug(string $string): string
    {
        $title = trim($string);
        $title = str_replace(" ", "-", $title);
        $title = str_replace('&', '', $title);
        preg_match('/\[(.*)\]\((.*)\)/', $title, $matches);
        $title = $this->removeMarkdownLink($title);
        $title = preg_replace('/[\.\(\):~;\/]/', '', $title);
        //$title

        return $title;
    }
}