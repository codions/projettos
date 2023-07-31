<?php

namespace App\Http\Controllers;

use App\Models\Doc;
use App\Models\DocPage;
use App\Models\DocVersion;
use Illuminate\Database\Eloquent\Builder;

class DocsController extends Controller
{
    public function __invoke($docSlug, $locale = 'en', string $versionSlug = null, string $chapterSlug = null, string $pageSlug = null)
    {
        // Get requested doc
        $doc = Doc::loadTranslation($locale)->where('slug', $docSlug)->firstOrFail();

        $version = $doc->versions()->first();
        $chapter = null;
        $page = null;

        if (filled($versionSlug)) {
            // Get requested version
            $version = DocVersion::loadTranslation($locale)
                ->where('doc_id', $doc->id)
                ->where('slug', $versionSlug)->first();
        }

        if (filled($chapterSlug)) {
            // Get requested chapter
            $chapter = DocPage::loadTranslation($locale)
                ->where('doc_id', $doc->id)
                ->where('slug', $chapterSlug)
                ->when(filled($version), function (Builder $query) use ($version): Builder {
                    return $query->where('version_id', $version->id);
                })->first();
        }

        if (filled($pageSlug)) {
            // Get requested page
            $page = DocPage::loadTranslation($locale)
                ->where('doc_id', $doc->id)
                ->where('slug', $pageSlug)
                ->when(filled($version), function (Builder $query) use ($version): Builder {
                    return $query->where('version_id', $version->id);
                })
                ->first();
        }

        return view('docs', [
            'doc' => $doc,
            'version' => $version,
            'chapter' => $chapter,
            'page' => $page ?? $chapter,
            'locale' => $locale,

            'versions' => $this->getVersions($doc, $locale),
            'chapters' => $this->getPages($version, $locale),

            'locales' => [
                'en' => 'English',
                'pt_BR' => 'Portuguese (Brazil)',
            ],
        ]);
    }

    private function getVersions($doc, $locale = null)
    {
        $doc = ($doc instanceof Doc) ? $doc->id : $doc;

        return DocVersion::loadTranslation($locale)
            ->where('doc_id', $doc)
            ->orderBy('id', 'desc')
            ->get();
    }

    private function getPages($version, $locale = null)
    {
        $version = ($version instanceof DocVersion) ? $version->id : $version;

        return DocPage::loadTranslation($locale)
            ->root()
            ->where('version_id', $version)
            ->orderBy('order')
            ->get();
    }
}
