<?php

namespace App\Observers;

use App\Models\Doc;
use Illuminate\Support\Facades\Storage;

class DocObserver
{
    public function deleting(Doc $doc)
    {
        try {
            Storage::delete('public/og-' . $doc->slug . '-' . $doc->id . '.jpg');
        } catch (\Throwable $exception) {
        }

        $doc->versions()->delete();
        $doc->pages()->delete();
    }
}
