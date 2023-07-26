<?php

namespace App\Observers;

use App\Models\DocPage;
use Illuminate\Support\Facades\Storage;

class DocPageObserver
{
    public function deleting(DocPage $page)
    {
        try {
            Storage::delete('public/og-' . $page->slug . '-' . $page->id . '.jpg');
        } catch (\Throwable $exception) {
        }

        $page->pages()->delete();
    }
}
