<?php

namespace Dblencowe\Repository\Contracts;

interface RepositoryInterface
{
    /**
     * Data source this repository represents
     *
     * @return string Model
     */
    public function model(): string;

    /**
     * Get a collection of results
     *
     * @param array $columns Columns to add to the select clause
     * @return mixed
     */
    public function all(array $columns = []);

    /**
     * Create a record
     *
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes);

    /**
     * @param mixed $identifier value to perform the lookup on
     * @param array $attributes Attributes to update
     * @param string $lookupKey Column to perform the lookup on
     * @return mixed
     */
    public function update($identifier, array $attributes, $lookupKey = 'id');

    /**
     * @param mixed $identifier Value to perform the lookup on
     * @param array $columns Columsn to use for the select clause
     * @return mixed
     */
    public function find($identifier, array $columns = ['*']);

    /**
     * Return a single result based upon a specified lookup condition
     *
     * @param string $attribute
     * @param string $value
     * @param array $columns
     * @return mixed
     */
    public function findBy(string $attribute, string $value, array $columns = []);

    /**
     * Paginate a result set
     *
     * @param int $perPage
     * @param array $columns
     * @return mixed
     */
    public function paginate(int $perPage = 15, array $columns = []);
}
