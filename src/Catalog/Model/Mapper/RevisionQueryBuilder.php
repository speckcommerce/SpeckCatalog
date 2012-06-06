<?php

namespace Catalog\Model\Mapper;

class RevisionQueryBuilder
{
    protected $userId;
    protected $table;
    protected $tableName;
    protected $whereString = "\nWHERE 1";
    protected $joinString = "";
    protected $fields = array();

    public function __construct($tableName, $fields, $select, $userId=null)
    {
        $this->tableName = $tableName;
        $this->userId = (int) $userId;
        foreach ($fields as $field) $this->fields[] = array($this->tableName, $field);
        
        $raw = $select->getRawState();
        foreach($raw['where']->getPredicates() as $predicate){
            $operator = $predicate[1];
            $right = (is_numeric($operator->getRight()) ? $operator->getRight() : '"' . $operator->getRight() . '"');
            $this->whereString .= " {$predicate[0]} ({$operator->getLeft()} {$operator->getOperator()} {$right})"; 
        }   
        foreach ($raw['joins'] as $join) $this->joinString .= $this->joinTable($join['name'], $join['on']);
    }
    
    public function build()
    { 
        if (null === $this->userId){
            return "SELECT\n {$this->getFieldString()} \n"
                 . "FROM {$this->tableName}\n"
                 . $this->joinString
                 . $this->whereString . " AND ({$this->tableName}.rev_active = 1) \n";
        }
        $ret = "SELECT\n {$this->getFieldString()} \n"
             . "FROM(\n" . $this->subQuery('record_id', $this->tableName) . ") as t2\n"
             . "JOIN {$this->tableName} ON t2.max_rev_id = {$this->tableName}.rev_id\n"    
             . $this->joinString
             . $this->whereString
             . "\n";
        return $ret;
    }

    private function joinTable($table, $on)
    {
        $groupfield='record_id'; 
        if(strstr($table, 'linker')){
            $this->fields[] = array($table, 'linker_id');
            $groupField = 'linker_id';
        }
        if(null === $this->userId) return "JOIN {$table} ON {$on}";   
        return "JOIN (\n"
             . "  SELECT * FROM(\n" . $this->subQuery($groupField, $table) . "  ) as l2\n"
             . "  JOIN {$table} ON l2.max_rev_id = {$table}.rev_id\n"
             . ") as {$table} ON {$on}";
    }

    private function subQuery($groupField, $tableName)
    {
        return "    SELECT max( rev_id ) AS max_rev_id\n"
             . "    FROM {$tableName} as g1\n"
             . "    WHERE (rev_user_id = {$this->userId} OR (rev_user_id IS NULL AND rev_eol_datetime IS NULL))\n"
             . "    GROUP BY {$groupField}, rev_user_id\n";
    }

    private function getFieldString()
    {
        $fields = array();
        foreach($this->fields as $field){
            $fields[] = implode('.',$field);
        }
        return implode(",\n ", $fields);
    }
}
