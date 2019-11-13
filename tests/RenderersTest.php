<?php


namespace Cbwar\Diff\Tests;


use Cbwar\Diff\Diff;
use Cbwar\Diff\Renderer\Html\Inline;
use Cbwar\Diff\Renderer\Html\SideBySide;
use Cbwar\Diff\Renderer\Text\Context;
use Cbwar\Diff\Renderer\Text\Unified;
use DOMDocument;
use PHPUnit\Framework\TestCase;

class RenderersTest extends TestCase
{
    public $diff;

    public function setUp(): void
    {
        parent::setUp();
        $a = explode("\n", file_get_contents(__DIR__ . '/fixtures/a.txt'));
        $b = explode("\n", file_get_contents(__DIR__ . '/fixtures/b.txt'));
        $this->diff = new Diff($a, $b, [
        ]);
    }


    public function testSideBySide()
    {
        $renderer = new SideBySide();
        $html = $this->diff->Render($renderer);
        $expectedHtml = file_get_contents(__DIR__ . '/fixtures/sidebyside.html');

        $dom = new DOMDocument("1.0");
        $dom->formatOutput = true;
        $dom->loadHTML($html);

        $expected = new DOMDocument("1.0");
        $expected->formatOutput = true;
        $expected->loadHTML($expectedHtml);

        $this->assertEquals($expected->saveHTML(), $dom->saveHTML());
    }

    public function testInline()
    {
        $renderer = new Inline();
        $html = $this->diff->Render($renderer);
        $expectedHtml = file_get_contents(__DIR__ . '/fixtures/inline.html');

        $dom = new DOMDocument("1.0");
        $dom->formatOutput = true;
        $dom->loadHTML($html);

        $expected = new DOMDocument("1.0");
        $expected->formatOutput = true;
        $expected->loadHTML($expectedHtml);

        $this->assertEquals($expected->saveHTML(), $dom->saveHTML());
    }

    public function testUnified()
    {
        $renderer = new Unified([
            'eol' => "\n",
        ]);
        $txt = $this->diff->render($renderer);
        $expectedTxt = file_get_contents(__DIR__ . '/fixtures/unified.txt');
        $this->assertEquals($expectedTxt, $txt);
    }

    public function testContext()
    {
        $renderer = new Context([
            'eol' => "\n",
        ]);
        $txt = $this->diff->render($renderer);
        $expectedTxt = file_get_contents(__DIR__ . '/fixtures/context.txt');
        $this->assertEquals($expectedTxt, $txt);
    }

}