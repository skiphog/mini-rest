<?php

namespace System\Database;

use PDO;
use App\Filters\Filter;
use System\Http\FormRequest;
use NilPortugues\Sql\QueryBuilder\Manipulation\Select;
use NilPortugues\Sql\QueryBuilder\Builder\MySqlBuilder;

/**
 * Class QueryBuilder
 *
 * @package System\Database
 */
class Builder
{
    /**
     * @var MySqlBuilder
     */
    protected $builder;

    /**
     * @var
     */
    protected $query;


    /**
     * @var string
     */
    protected $className;


    /**
     * QueryBuilder constructor.
     *
     * @param string $className
     */
    public function __construct(string $className)
    {
        $this->className = $className;
        $this->builder = new MySqlBuilder();
    }

    /**
     * @noinspection PhpUndefinedVariableInspection
     * @noinspection PhpUndefinedFieldInspection
     *
     * @return $this
     */
    public function select(): Builder
    {
        $this->query = $this->builder->select($this->className::$table);

        return $this;
    }

    /**
     * @noinspection PhpPossiblePolymorphicInvocationInspection
     * @noinspection PhpUndefinedVariableInspection
     * @noinspection PhpUndefinedFieldInspection
     *
     * @param FormRequest $request
     *
     * @return int
     */
    public function insert(FormRequest $request): int
    {
        $this->query = $this->builder
            ->insert($this->className::$table)
            ->setValues($request->post());

        $stmt = db()
            ->prepare($this->builder->write($this->query));
        $stmt->execute($this->builder->getValues());

        return (int)db()->lastInsertId();
    }

    /**
     * @noinspection PhpUndefinedVariableInspection
     * @noinspection PhpUndefinedFieldInspection
     *
     * @param Model $model
     *
     * @return Model
     */
    public function update(Model $model): Model
    {
        $this->query = $this->builder
            ->update($this->className::$table)
            ->setValues($model->asArray())
            ->where()
            ->equals('id', $model->id)
            ->end();

        $stmt = db()
            ->prepare($this->builder->write($this->query));
        $stmt->execute($this->builder->getValues());

        return $model;
    }

    /**
     * @noinspection PhpUndefinedVariableInspection
     * @noinspection PhpUndefinedFieldInspection
     *
     * @return $this
     */
    public function delete(): Builder
    {
        $this->query = $this->builder->delete($this->className::$table);

        return $this;
    }

    public function where(array $params)
    {
        $this->query = $this->query->where();

        foreach ($params as $key => $value) {
            $this->query->equals($key, $value);
        }

        return $this;
    }

    public function whereIn(string $column, array $values)
    {
        $this->query = $this->query->where()
            ->in($column, $values);

        return $this;
    }

    /**
     * @noinspection PhpUndefinedVariableInspection
     * @noinspection PhpUndefinedFieldInspection
     *
     * @param string $table
     * @param string $column
     * @param        $param
     *
     * @return $this
     */
    public function join(string $table, string $column, $param): self
    {
        $this->query->join($table, 'id', $column)
            ->on()
            ->equals($this->className::$manyKeyThrow, $param);

        return $this;
    }

    /**
     * @return array
     */
    public function all()
    {
        $stmt = db()->prepare($this->result());
        $stmt->execute($this->builder->getValues());

        return $stmt->fetchAll(PDO::FETCH_CLASS, $this->className);
    }

    public function withModel(string $model)
    {
        $keys = array_column($first = $this->all(), 'id');

        /** @var Model $model */
        $second = $model::select()
            ->whereIn($model::$manyKey, $keys)
            ->all();


        foreach ($first as $item) {
            $item->{$model::$table} = array_values(array_filter($second, static function ($v) use ($item, $model) {
                return $v->{$model::$manyKey} === $item->id;
            }));
        }

        return $first;
    }

    /**
     * @return mixed
     */
    public function one()
    {
        $stmt = db()->prepare($this->result());
        $stmt->execute($this->builder->getValues());

        return $stmt->fetchObject($this->className);
    }

    /**
     * @return string
     */
    protected function result(): string
    {
        if (!($this->query instanceof Select)) {
            $this->query = $this->query->end();
        }

        return $this->builder->write($this->query);
    }

    /**
     * @param Filter $filter
     *
     * @return $this
     */
    public function withFilter(Filter $filter): Builder
    {
        $this->query = $filter->apply($this->query);

        return $this;
    }
}
