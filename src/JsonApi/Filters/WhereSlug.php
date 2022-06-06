<?php

namespace A17\Twill\API\JsonApi\Filters;

use LaravelJsonApi\Core\Support\Str;
use LaravelJsonApi\Eloquent\Contracts\Filter;
use LaravelJsonApi\Eloquent\Filters\Concerns\DeserializesValue;
use LaravelJsonApi\Eloquent\Filters\Concerns\IsSingular;

class WhereSlug implements Filter
{
    use DeserializesValue;
    use IsSingular;

    /**
     * @var string
     */
    private string $name;

    /**
     * @var string
     */
    private string $column;

    /**
     * Create a new filter.
     *
     * @param string $name
     * @param string|null $column
     * @return WhereSlug
     */
    public static function make(string $name, string $column = null): self
    {
        return new static($name, $column);
    }

    /**
     * WhereSlug constructor.
     *
     * @param string $name
     * @param string|null $column
     */
    public function __construct(string $name, string $column = null)
    {
        $this->name = $name;
        $this->column = $column ?: Str::underscore($name);
    }

    /**
     * Get the key for the filter.
     *
     * @return string
     */
    public function key(): string
    {
        return $this->name;
    }

    /**
     * Apply the filter to the query.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply($query, $value)
    {
        $column = $this->column;
        $deserializedValue = $this->deserialize($value);

        return $query->whereHas('slugs', function ($query) use ($column, $deserializedValue) {
            return $query
                ->where('active', 1)
                ->where('locale', app()->getLocale())
                ->when(is_array($deserializedValue), function ($query) use ($column, $deserializedValue) {
                    $query->whereIn($query->getModel()->qualifyColumn($column), $deserializedValue);
                })
                ->when(is_string($deserializedValue), function ($query) use ($column, $deserializedValue) {
                    $query->where($query->getModel()->qualifyColumn($column), $deserializedValue);
                });
        });
    }
}
