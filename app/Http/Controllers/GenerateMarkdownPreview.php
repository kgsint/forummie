<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\LaravelMarkdown\MarkdownRenderer;

class GenerateMarkdownPreview extends Controller
{
    public function __invoke(Request $request)
    {
        $renderedHtml = app(MarkdownRenderer::class)
                                                ->highlightTheme('material-theme-palenight')
                                                ->toHtml($request->body ?? '');

        return response()->json([
            'markdown_html' => $renderedHtml,
        ]);
    }
}
