<?php
/**
 * Copyright (C) 2014 David Young
 *
 * Builds a delete query
 */
namespace RDev\Models\Databases\SQL\QueryBuilders\MySQL;
use RDev\Models\Databases\SQL\QueryBuilders;

class DeleteQuery extends QueryBuilders\DeleteQuery
{
    /** @var int|string $limit The number of rows to limit to */
    protected $limit = -1;

    /**
     * {@inheritdoc}
     */
    public function getSQL()
    {
        $sql = parent::getSQL();

        // Add a limit
        if($this->limit !== -1)
        {
            $sql .= " LIMIT " . $this->limit;
        }

        return $sql;
    }

    /**
     * Limits the number of rows returned by the query
     *
     * @param int|string $numRows The number of rows to limit in the results or the named placeholder value that will contain the number of rows
     * @return $this
     */
    public function limit($numRows)
    {
        $this->limit = $numRows;

        return $this;
    }
} 