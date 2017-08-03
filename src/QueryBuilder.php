<?php

namespace Tourbillon\Dbal;

/**
 * Description of QueryBuilder
 *
 * @author gjean
 */
abstract class QueryBuilder {
    
    protected $data;

    protected $table;

    protected $joins;

    protected $conditions;
    
    protected $havings;
    
    protected $sorts;
    
    protected $groups;
    
    protected $maxResult;
    
    protected $firstResult;
    
    protected $parameters;

    protected $queryType;

    const JOIN_INNER = 1;
    const JOIN_LEFT = 2;
    
    const ORDER_ASC = 'ASC';
    const ORDER_DESC = 'DESC';
    
    const QUERY_TYPE_SELECT = 1;
    const QUERY_TYPE_INSERT = 2;
    const QUERY_TYPE_UPDATE = 3;
    const QUERY_TYPE_DELETE = 4;
    
    public function __construct() {
        $this->data = array();
        $this->joins = array();
        $this->parameters = array();
        $this->conditions = array();
        $this->sorts = array();
        $this->groups = array();
        $this->queryType = self::QUERY_TYPE_SELECT;
    }
    
    /**
     * 
     * @param type $data
     * @return $this
     */
    public function select(...$data) {
        foreach ($data as $d) {
            $this->data[] = $d;
        }
        return $this;
    }
    
    public function insert($table) {
        $this->queryType = self::QUERY_TYPE_INSERT;
    }
    
    public function update($table) {
        $this->queryType = self::QUERY_TYPE_UPDATE;
    }
    
    public function delete() {
        $this->queryType = self::QUERY_TYPE_DELETE;
    }
    
    /**
     * 
     * @param type $table
     * @return $this
     */
    public function from($table, $alias = null) {
        $this->table = ['table' => $table, 'alias' => null !== $alias ? $alias : $table];
        return $this;
    }
    
    public function set($property, $value) {
        
    }
    
    /**
     * 
     * @param type $table
     * @param type $condition
     * @param type $type
     * @return $this
     */
    public function join($table, $alias, $condition, $type = self::JOIN_INNER) {
        $this->joins[] = [
            'table' => ['table' => $table, 'alias' => null !== $alias ? $alias : $table],
            'condition' => $condition,
            'type' => $type
        ];
        return $this;
    }
    
    /**
     * 
     * @param type $condition
     * @param array $parameters
     * @return $this
     */
    public function where($condition, array $parameters = array()) {
        $this->conditions[] = $condition;
        $this->parameters = array_merge($this->parameters, $parameters);
        return $this;
    }
    
    /**
     * 
     * @param type $condition
     * @param array $parameters
     * @return $this
     */
    public function having($condition, array $parameters = array()) {
        $this->havings[] = $condition;
        $this->parameters = array_merge($this->parameters, $parameters);
        return $this;
    }
    
    /**
     * 
     * @param type $property
     * @param type $tri
     * @return $this
     */
    public function orderBy($property, $tri = self::ORDER_ASC) {
        $this->sorts[$property] = $tri;
        return $this;
    }
    
    /**
     * 
     * @param type $property
     * @return $this
     */
    public function groupBy($property) {
        $this->groups[] = $property;
        return $this;
    }
    
    /**
     * 
     * @param type $maxResult
     * @return $this
     */
    public function setMaxResult($maxResult) {
        $this->maxResult = $maxResult;
        return $this;
    }
    
    /**
     * 
     * @param type $firstResult
     * @return $this
     */
    public function setFirstResult($firstResult) {
        $this->firstResult = $firstResult;
        return $this;
    }
    
    /**
     * 
     * @param type $key
     * @param type $value
     * @return $this
     */
    public function setParameter($key, $value) {
        $this->parameters[$key] = $value;
        return $this;
    }
    
    /**
     * Transform le QueryBuilder en requete SQL
     */
    public abstract function getQuery();
}
