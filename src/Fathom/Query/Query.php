<?php

namespace Fathom\Query;

use Fathom\Persistence\Util\BasePeer;

class Query
{
    private $fqdn;

    private $start_alias;

    private $wheres = array();

    protected $query;

    public function start($fqdn, $alias)
    {
        $this->fqdn = $fqdn;
        $this->start_alias = $alias;

        return $this;
    }

    public function where($property, $value)
    {
        $this->wheres[$property] = $value;
        return $this;
    }

    public function andWhere($property, $value)
    {
        $this->where($property, $value);
    }

    public function getQuery()
    {
        $query = 'START ';
        $query .= $this->start_alias.'=node:node_auto_index(';
        $query .= 'fqdn="'.$this->fqdn.'") ';

        if(!empty($this->wheres)){
            $nbr_where = count($this->wheres);
            $inc = 1;
            $query .= 'WHERE (';
            foreach($this->wheres as $k=>$v){
                $query .= $this->start_alias.'.'.$k.'="'.$v.'"';
                if($nbr_where == 1){
                    $query .= ')';
                } elseif($nbr_where > 1){
                    $query .= ', ';
                    $query .= $this->start_alias.'.'.$k.'="'.$v.'"';
                    if($inc == $nbr_where){
                        $query .= ')';
                    }
                }
                $inc++;

            }
            $query .= ' RETURN '.$this->start_alias.';';
        }

        $this->query = $query;

        return $this->query;
    }

    public function getWheres(){
        return $this->where;
    }

    public function findByXXX($key, $value, $conn, $fqdn, $alias = 'n')
    {
        $fqdn = str_replace('\\', '\\\\', $fqdn);
        $q = $this->start($fqdn, $alias);
        $q->where($key, $value);
        $query = $q->getQuery();
        $peer = new BasePeer();
        $n = $peer->query($query, $conn);
        return $n;
    }
}