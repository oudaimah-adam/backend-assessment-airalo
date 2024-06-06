<?php

declare(strict_types=1);

namespace App\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

interface RepositoryInterface
{
    public function all(): Collection;

    /**
     * @throws ModelNotFoundException
     */
    public function find(int $id): Model;

    /**
     * @param  array<string, mixed>  $attributes
     */
    public function create(array $attributes): Model;

    /**
     * @param  array<string, mixed>  $attributes
     *
     * @throws ModelNotFoundException
     */
    public function update(int $id, array $attributes): Model;

    /**
     * @throws ModelNotFoundException
     */
    public function delete(int $id): bool;
}
