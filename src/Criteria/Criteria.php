<?php

namespace Dblencowe\Repository\Criteria;

use Dblencowe\Repository\Contracts\RepositoryInterface as Repository;
use Dblencowe\Repository\Contracts\RepositoryInterface;

abstract class Criteria
{
    abstract public function apply($model, Repository $repository);
}
