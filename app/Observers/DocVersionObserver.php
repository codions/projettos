<?php

namespace App\Observers;

use App\Models\DocVersion;

class DocVersionObserver
{
    public function deleting(DocVersion $version)
    {
        $version->pages()->delete();
    }
}
