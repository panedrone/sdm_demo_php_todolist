<?php
namespace dao;

include_once 'DataStore.php';

include_once 'Group.php';

use \dto\Group;

// This code was generated by a tool. Don't modify it manually.
// http://sqldalmaker.sourceforge.net

class GroupsDao {

    protected $ds;

    public function __construct(\DataStore $ds) {
        $this->ds = $ds;
    }

    /**
     * (C)RUD: groups
     * Generated values are passed to DTO.
     * @param Group $p
     * @return TRUE on success or FALSE on failure
     */
    public function createGroup(Group $p) {
        $sql = "insert into groups (g_name) values (?)";
        $ai_values = array("g_id" => null);
        $res = $this->ds->insert($sql, array($p->getGName()), $ai_values);
        $p->setGId($ai_values["g_id"]);
        return $res;
    }

    /**
     * C(R)UD: groups
     * @param Integer $gId
     * @return Group or FALSE on failure
     */
    public function readGroup($gId) {
        $sql = "select * from groups where g_id=?";
        $row = $this->ds->queryRow($sql, array($gId));
        if ($row) {
            $obj = new Group();
            $obj->setGId($row["g_id"]); // q <- t
            $obj->setGName($row["g_name"]); // q <- t
            return $obj;
        }
        return FALSE;
    }

    /**
     * CR(U)D: groups
     * @param Group $p
     * @return TRUE on success or FALSE on failure
     */
    public function updateGroup(Group $p) {
        $sql = "update groups set g_name=? where g_id=?";
        return $this->ds->execDML($sql, array($p->getGName(), $p->getGId()));
    }

    /**
     * CRU(D): groups
     * @param Integer $gId
     * @return TRUE on success or FALSE on failure
     */
    public function deleteGroup($gId) {
        $sql = "delete from groups where g_id=?";
        return $this->ds->execDML($sql, array($gId));
    }

    /**
     * @return Group[] or FALSE on failure
     */
    public function getGroups() {
        $sql = "select g.*, "
                . "\n (select count(*) from tasks where g_id=g.g_id) as tasks_count"
                . "\n from groups g";
        $res = array();
        $_map_cb = function ($row) use (&$res) {
            $obj = new Group();
            $obj->setGId($row["g_id"]); // q <- q
            $obj->setGName($row["g_name"]); // q <- q
            $obj->setTasksCount($row["tasks_count"]); // q <- q
            array_push($res, $obj);
        };
        $this->ds->queryRowList($sql, array(), $_map_cb);
        return $res;
    }

    /**
     * @param String $g_id
     * @return TRUE on success or FALSE on failure
     */
    public function deleteTasks($g_id) {
        $sql = "delete from tasks where g_id=?";
        return $this->ds->execDML($sql, array($g_id));
    }

}
