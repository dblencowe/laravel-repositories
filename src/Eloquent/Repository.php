<?php

namespace Dblencowe\Repository\Eloquent;

use Dblencowe\Repository\Contracts\CriteriaInterface;
use Dblencowe\Repository\Contracts\RepositoryInterface;
use Dblencowe\Repository\Criteria\Criteria;
use Dblencowe\Repository\Exceptions\RepositoryException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Application;

abstract class Repository implements RepositoryInterface, CriteriaInterface
{
    /** @var Application $app */
    private $app;

    /** @var $model */
    protected $model;

    /** @var Collection $criteria */
    protected $criteria;

    /** @var bool $skipCriteria */
    protected $skipCriteria = false;

    /**
     * @param Application $app
     * @param Collection $collection
     */
    public function __construct(Application $app, Collection $collection)
    {
        $this->app = $app;
        $this->criteria = $collection;
        $this->resetScope();
        $this->setModel();
    }

    /**
     * @inheritdoc
     */
    abstract public function model(): string;

    /**
     * @inheritdoc
     */
    private function setModel(): Model
    {
        $model = $this->app->make($this->model());

        if (!$model instanceof Model) {
            throw new RepositoryException("Class {$this->model()} must be an instant of " . Model::class);
        }

        return $this->model = $model;
    }

    /**
     * @inheritdoc
     */
    public function all(array $columns = ['*'])
    {
        return $this->model->get($columns);
    }

    /**
     * @inheritdoc
     */
    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

    /**
     * @inheritdoc
     */
    public function update($identifier, array $attributes, $lookupKey = 'id')
    {
        return $this->model->where($lookupKey, '=', $identifier)->update($attributes);
    }

    /**
     * @inheritdoc
     */
    public function find($identifier, array $columns = ['*'])
    {
        return $this->model->find($identifier, $columns);
    }

    /**
     * @inheritdoc
     */
    public function findBy(string $attribute, string $value, array $columns = ['*'])
    {
        return $this->model->where($attribute, '=', $value)->first($columns);
    }

    /**
     * @inheritdoc
     */
    public function paginate(int $perPage = 15, array $columns = ['*'])
    {
        return $this->model->paginate($perPage, $columns);
    }

    /**
     * @inheritdoc
     */
    public function resetScope()
    {
        $this->skipCriteria(false);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function skipCriteria($status = true)
    {
        $this->skipCriteria = $status;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getCriteria(): Collection
    {
        return $this->criteria;
    }

    /**
     * @inheritdoc
     */
    public function getByCriteria(Criteria $criteria)
    {
        $this->model = $criteria->apply($this->model, $this);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function pushCriteria(Criteria $criteria)
    {
        $this->criteria->push($criteria);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function applyCriteria()
    {
        if ($this->skipCriteria === true) {
            return $this;
        }

        /** @var Collection $criteria */
        foreach ($this->getCriteria() as $criteria) {
            if ($criteria instanceof Criteria) {
                $this->model = $criteria->apply($this->model, $this);
            }
        }

        return $this;
    }
}
