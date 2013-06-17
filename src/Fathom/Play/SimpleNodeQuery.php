<?php
/**
 * Created by JetBrains PhpStorm.
 * User: christophe
 * Date: 22/05/13
 * Time: 23:29
 * To change this template use File | Settings | File Templates.
 */

namespace Fathom\Play;

use Fathom\Play\SimpleNode;
use Fathom\Query\Query;

class SimpleNodeQuery extends Query
{
    protected $fqdn = 'Fathom\Play\SimpleNode';

    protected $conn;

    public function __construct($conn = null)
    {
        $this->conn = $conn;
    }

    public function findById($id)
    {
        $n = $this->findByXXX('uuid', $id, $this->conn, $this->fqdn);
        return $n;
    }
}