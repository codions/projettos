<?php

namespace Xetaio\Mentions\Models\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Xetaio\Mentions\Models\Mention;
use Xetaio\Mentions\Models\Repositories\MentionRepository;

trait HasMentionsTrait
{
    /**
     * Create a new mention for the given model(s).
     *
     * @return bool|\Xetaio\Mentions\Models\Mention
     */
    public function mention(Model $model, bool $notify = true): Mention
    {
        return MentionRepository::create($this, $model, $notify);
    }

    /**
     * Gets all mentions for the given model.
     *
     * @return Collection Model
     */
    public function mentions(bool $resolve = true)
    {
        $mentions = MentionRepository::get($this);

        if ($resolve) {
            $mentions = $mentions->map(function ($mention) {
                return $mention->recipient();
            });
        }

        return $mentions;
    }
}
