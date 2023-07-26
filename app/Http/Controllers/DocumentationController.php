<?php

namespace App\Http\Controllers;

use App\Models\Doc;
use App\Models\DocPage;
use App\Models\DocVersion;
use Illuminate\Database\Eloquent\Builder;

class DocumentationController extends Controller
{
    protected $locale = 'en';

    public function __invoke($docSlug, string $versionSlug = null, string $chapterSlug = null, string $pageSlug = null)
    {
        // Get requested doc
        $doc = Doc::loadTranslation($this->locale)->where('slug', $docSlug)->firstOrFail();

        $version = null;
        $chapter = null;
        $page = null;

        if (filled($versionSlug)) {
            // Get requested version
            $version = DocVersion::loadTranslation($this->locale)
                ->where('doc_id', $doc->id)
                ->where('slug', $versionSlug)->firstOrFail();
        }

        if (filled($chapterSlug)) {
            // Get requested chapter
            $chapter = DocPage::loadTranslation($this->locale)
                ->where('doc_id', $doc->id)
                ->where('slug', $chapterSlug)
                ->when(filled($version), function (Builder $query) use ($version): Builder {
                    return $query->where('version_id', $version->id);
                })->firstOrFail();
        }

        if (filled($pageSlug)) {
            // Get requested page
            $page = DocPage::loadTranslation($this->locale)
                ->where('doc_id', $doc->id)
                ->where('slug', $pageSlug)
                ->when(filled($version), function (Builder $query) use ($version): Builder {
                    return $query->where('version_id', $version->id);
                })
                ->firstOrFail();
        }

        dd([
            'doc' => $doc,
            'docSlug' => $docSlug,

            'version' => $version,
            'versionSlug' => $versionSlug,

            'chapter' => $chapter,
            'chapterSlug' => $chapterSlug,

            'page' => $page,
            'pageSlug' => $pageSlug,

        ]);
    }
}
