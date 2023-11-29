<?php

namespace IBroStudio\Polyteam\Models\Traits;

use App\Models\Teams\Studio;
use IBroStudio\Polyteam\Models\Polyteam;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Config;
use Mpociot\Teamwork\Events\UserJoinedTeam;
use Mpociot\Teamwork\Events\UserLeftTeam;
use Mpociot\Teamwork\Exceptions\UserNotInTeamException;

trait UserHasPolyteams
{
    abstract protected function getCurrentPolyteamId(): int|null;
    abstract protected function setCurrentPolyteamId(int|null $polyteam_id): void;
    abstract protected function polyteams(): BelongsToMany;

    public function invites(): HasMany
    {
        return $this->hasMany(Config::get('polyteam.models.invite'), 'email', 'email');
    }

    protected function isOwnerOfPolyteam($team): bool
    {
        $team_id = $this->retrievePolyteamId($team);

        return ($this->polyteams()
            ->where('owner_id', $this->getKey())
            ->where('team_id', $team_id)->first()
        ) ? true : false;
    }

    protected function isOwner(): bool
    {
        return ($this->polyteams()->where('owner_id', '=', $this->getKey())->first()) ? true : false;
    }

    protected function getPolyteamRelationName(): string
    {
        return 'studios';
    }

    protected function getCurrentPolyteamRelationName(): string
    {
        return 'currentStudio';
    }

    protected function attachPolyteam(Polyteam|array $polyteam, array $pivotData = [])
    {
        $polyteam = $this->retrievePolyteamId($polyteam);

        if (is_null($this->getCurrentPolyteamId())) {
            $this->setCurrentPolyteamId($polyteam);
            $this->save();

            if ($this->relationLoaded($this->getCurrentPolyteamRelationName())) {
                $this->load($this->getCurrentPolyteamRelationName());
            }
        }

        $this->load($this->getPolyteamRelationName());

        if (! $this->polyteams->contains($polyteam)) {
            $this->polyteams()->attach($polyteam, $pivotData);

            event(new UserJoinedTeam($this, $polyteam));

            if ($this->relationLoaded($this->getPolyteamRelationName())) {
                $this->load($this->getPolyteamRelationName());
            }
        }

        return $this;
    }

    public function detachPolyteam(Polyteam|array $polyteam): self
    {
        $polyteam = $this->retrievePolyteamId($polyteam);
        $this->polyteams()->detach($polyteam);

        event(new UserLeftTeam($this, $polyteam));

        if ($this->relationLoaded($this->getPolyteamRelationName())) {
            $this->load($this->getPolyteamRelationName());
        }

        if ($this->polyteams()->count() === 0 || $this->getCurrentPolyteamId() === $polyteam) {
            $this->setCurrentPolyteamId(null);
            $this->save();

            if ($this->relationLoaded($this->getCurrentPolyteamRelationName())) {
                $this->load($this->getCurrentPolyteamRelationName());
            }
        }

        return $this;
    }

    protected function switchPolyteam(Polyteam|array|int $polyteam): self
    {
        if ($polyteam !== 0 && $polyteam !== null) {
            $polyteam = $this->retrievePolyteamId($polyteam);
            $polyteamObject = (new Polyteam)->find($polyteam);
            if (!$polyteamObject) {
                $exception = new ModelNotFoundException();
                $exception->setModel(Polyteam::class);
                throw $exception;
            }
            if (!$polyteamObject->users->contains($this->getKey())) {
                $exception = new UserNotInTeamException();
                $exception->setTeam($polyteamObject->name);
                throw $exception;
            }
        }
        $this->setCurrentPolyteamId($polyteam);
        $this->save();

        if ($this->relationLoaded($this->getCurrentPolyteamRelationName())) {
            $this->load($this->getCurrentPolyteamRelationName());
        }

        return $this;
    }

    protected function createOwnedPolyteam(string $polyteamModel, array $data, bool $forceSwitchPolyteam = false): Polyteam
    {
        $team = $polyteamModel::create(array_merge($data, ['owner_id' => $this->id]));

        $this->attachPolyteam($team);

        if (
            $this->getCurrentPolyteamId() !== $team->id &&
            $forceSwitchPolyteam
        ) {
            $this->switchPolyteam($team);
        }

        return $team;
    }

    protected function retrievePolyteamId($polyteam): mixed
    {
        if (is_object($polyteam)) {
            $polyteam = $polyteam->getKey();
        }
        if (is_array($polyteam) && isset($polyteam['id'])) {
            $polyteam = $polyteam['id'];
        }

        return $polyteam;
    }

}
