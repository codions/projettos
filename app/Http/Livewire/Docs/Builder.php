<?php

namespace App\Http\Livewire\Docs;

use App\Models\Doc;
use App\Models\DocPage;
use App\Models\DocVersion;
use Livewire\Component;

class Builder extends Component
{
    public $locales = [
        'en' => 'English',
        'pt_BR' => 'Portuguese (Brazil)',
    ];

    public $locale = 'en';

    public $versionId;

    public $version;

    public $versions;

    public $chapters;

    public $page;

    public $pageId;

    public $doc;

    public $project;

    protected $listeners = [
        'refresh' => '$refresh',
        'updatedDoc' => '$refresh',
        'version:deleted' => 'deletedVersion',
        'loadPage',
        'loadVersion',
    ];

    protected $queryString = [
        'locale',
        'versionId',
        'pageId',
    ];

    public function mount($docSlug): void
    {
        $this->getDoc($docSlug, $this->locale);

        $this->getVersions($this->doc, $this->locale);

        $this->loadVersion($this->versionId, $this->locale);

        $this->getPages($this->versionId, $this->locale);

        $this->project = $this->doc->project;

        if (! is_null($this->pageId)) {
            $this->loadPage($this->pageId);
        }
    }

    private function getDoc($docSlug, $locale = null)
    {
        $locale = (is_null($locale)) ? $this->locale : $locale;

        $this->doc = Doc::loadTranslation($locale)
            ->canBeHandledForCurrentUser()
            ->where('slug', $docSlug)
            ->firstOrFail();
    }

    private function getVersions($doc, $locale = null)
    {
        $doc = ($doc instanceof Doc) ? $doc->id : $doc;
        $locale = (is_null($locale)) ? $this->locale : $locale;

        $this->versions = DocVersion::loadTranslation($locale)
            ->canBeHandledForCurrentUser()
            ->where('doc_id', $doc)
            ->orderBy('id', 'desc')
            ->get();
    }

    public function getPages($version, $locale = null)
    {
        $version = ($version instanceof DocVersion) ? $version->id : $version;
        $locale = (is_null($locale)) ? $this->locale : $locale;

        $this->chapters = DocPage::loadTranslation($locale)
            ->canBeHandledForCurrentUser()
            ->root()
            ->where('version_id', $version)
            ->orderBy('order')
            ->get();
    }

    public function loadVersion($id = null, $locale = null)
    {
        $locale = (is_null($locale)) ? $this->locale : $locale;

        if (is_null($id)) {
            $this->version = $this->versions?->first();

            if ($this->version) {
                $this->versionId = $this->version->id;
            }
        } else {
            $this->versionId = $id;

            $this->version = DocVersion::loadTranslation($locale)
                ->canBeHandledForCurrentUser()
                ->findOrFail($id);
        }

        $this->getPages($this->versionId);

        $this->emit('version:loaded');
        $this->emit('refresh');
    }

    public function loadPage($id, $locale = null)
    {
        $this->pageId = $id;

        $locale = (is_null($locale)) ? $this->locale : $locale;

        $this->page = DocPage::loadTranslation($locale)
            ->canBeHandledForCurrentUser()
            ->where('id', $id)
            ->firstOrFail();

        $this->emit('page:loaded');
    }

    public function updatedVersionId($value)
    {
        $this->pageId = null;
        $this->page = null;

        $this->getPages($value, $this->locale);
    }

    public function newPage($parentId = null)
    {
        $page = DocPage::create([
            'title' => 'New Page',
            // 'order',
            'parent_id' => $parentId,
            'version_id' => $this->versionId,
            'project_id' => $this->doc->project_id,
            'doc_id' => $this->doc->id,
        ]);

        return redirect()->to($page->edit_url);
    }

    public function deletedVersion($deletedId)
    {
        // if ($this->versionId === $deletedId) {
        //     return redirect()->to($this->doc->edit_url);
        // }
    }

    public function render(): \Illuminate\Contracts\View\View
    {
        return view('livewire.docs.builder')
            ->layout(\App\View\Components\Layouts\Base::class);
    }
}
