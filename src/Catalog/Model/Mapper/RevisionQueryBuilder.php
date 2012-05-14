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
        foreach ($fields as $field){
            $this->fields[] = array($this->tableName, $field);
        }

        $raw = $select->getRawState();
        
        foreach($raw['where']->getPredicates() as $predicate){
            $operator = $predicate[1];
            $this->whereString .= " {$predicate[0]} ({$operator->getLeft()} {$operator->getOperator()} {$operator->getRight()})"; 
        }   

        foreach($raw['joins'] as $join){
            $this->joinString .= $this->joinTable($join['name'], $join['on']);
        }
    }
    
    public function build()
    {    
        return "SELECT\n {$this->getFieldString()} \n"
             . "FROM(\n"
             .    $this->groupingSelect('record_id', $this->tableName)
             . ") as t2\n"
             . "JOIN {$this->tableName} ON t2.max_rev_id = {$this->tableName}.rev_id"    
             . $this->joinString
             . $this->whereString;
    }
    
    private function groupingSelect($groupByField, $tableName)
    {
        return "    SELECT max( rev_id ) AS max_rev_id\n"
             . "    FROM {$tableName} as g1\n"
             . "    WHERE (rev_user_id = {$this->userId} OR (rev_user_id IS NULL AND rev_eol_datetime IS NULL))\n"
             . "    GROUP BY {$groupByField}, rev_user_id\n";
    }

    private function joinTable($table, $on)
    {
        if(strstr('linker', $table)){
            $this->fields[] = array($table, 'linker_id');
            $groupField = 'linker_id';
        }else{
            $groupField = 'record_id';
        }

        return "\n\n-- Joined table: '{$table}'\n"     
             . "JOIN (\n"
             . "  SELECT * FROM(\n"
             .      $this->groupingSelect($groupField, $table)
             . "  ) as l2\n"
             . "  JOIN {$table} ON l2.max_rev_id = {$table}.rev_id\n"
             . ") as {$table} ON {$on}";
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
