<?php

namespace Tourbillon\Dbal\Connection\Mysql;

use Tourbillon\Dbal\QueryBuilder as BaseQueryBuilder;

/**
 * Description of QueryBuilder
 *
 * @author gjean
 */
class QueryBuilder extends BaseQueryBuilder {

    private $query;
    
    public function getQuery() {
        $this->query = [];
        switch ($this->queryType) {
            case self::QUERY_TYPE_SELECT: $this->getQuerySelect(); break;
            case self::QUERY_TYPE_INSERT: $this->getQueryInsert(); break;
            case self::QUERY_TYPE_UPDATE: $this->getQueryUpdate(); break;
            case self::QUERY_TYPE_DELETE: $this->getQueryDelete(); break;
        }
        return implode(' ', $this->query);
    }
    
    private function getQuerySelect() {
        $this->transformSelect();
        $this->transformFrom();
        $this->transformJoin();
        $this->transformWhere();
        $this->transformGroupBy();
        $this->transformHaving();
        $this->transformOrderBy();
        $this->transformLimit();
        $this->transformOffset();
    }
    
    private function getQueryInsert() {
        $this->query[] = "INSERT INTO";
        $this->query[] = $this->table;
        
        $propertyKeys = [];
        $propertyValues = [];
        foreach ($this->sets as $property => $value) {
            $propertyKeys[] = $property;
            $propertyValues[] = ":{$property}";
            $this->setParameter($property, $value);
        }
        
        $this->query[] = "(" . implode(', ', $propertyKeys) . ")";
        $this->query[] = "VALUES";
        $this->query[] = "(" . implode(', ', $propertyValues) . ")";
    }
    
    private function getQueryUpdate() {
        if (empty($this->sets)) {
            throw new Exception('You need to set values to update');
        }
        
        $this->query[] = "UPDATE";
        $this->query[] = $this->table;
        $this->query[] = "SET";
        
        $propertyKeys = [];
        foreach ($this->sets as $property => $value) {
            $propertyKeys[] = "$property = :{$property}";
            $this->setParameter($property, $value);
        }
        
        $this->query[] =  implode(', ', $propertyKeys);
        
        $this->transformWhere();
    }
    
    private function getQueryDelete() {
        
    }

    private function transformSelect() {
        $this->query[] = "SELECT";
        if (!empty($this->data)) {
            $data = [];
            foreach ($this->data as $d) {
                $data[] = $d;
            }
            $this->query[] = implode(', ', $data);
        } else {
            $this->query[] = "*";
        }
    }
    
    private function transformFrom() {
        $this->query[] = "FROM";
        $this->query[] = $this->table['table'];
        $this->query[] = $this->table['alias'];
    }
    
    private function transformJoin() {
        if (!empty($this->joins)) {
            
        }
            
    }
    
    private function transformWhere() {
        if (!empty($this->conditions)) {
            $this->query[] = "WHERE";
            
            $condition = [];
            foreach ($this->conditions as $cond) {
                $condition[] = $cond;
            }
            
            $this->query[] = implode(' AND ', $condition);
        }
    }
    
    private function transformGroupBy() {
        if (!empty($this->groups)) {
            $this->query[] = "GROUP BY";
            
            $properties = [];
            foreach ($this->groups as $value) {
                $properties[] = $value;
            }
            
            $this->query[] = implode(', ', $properties);
        }
    }
    
    private function transformHaving() {
        if (!empty($this->havings)) {
            $this->query[] = "HAVING";
            
            $condition = [];
            foreach ($this->havings as $cond) {
                $condition[] = $cond;
            }
            
            $this->query[] = implode(' AND ', $condition);
        }
    }
    
    private function transformOrderBy() {
        if (!empty($this->sorts)) {
            $this->query[] = "ORDER BY";
            $sorts = [];
            foreach ($this->sorts as $property => $tri) {
                $sorts[] = $property . ' ' . $tri;
            }
            $this->query[] = implode(', ', $sorts);
        }
    }
    
    private function transformLimit() {
        if (null !== $this->maxResult) {
            $this->query[] = "LIMIT";
            $this->query[] = $this->maxResult;
        }
        
    }
    
    private function transformOffset() {
        if (null !== $this->firstResult) {
            $this->query[] = "OFFSET";
            $this->query[] = $this->firstResult;
        }
    }
}
