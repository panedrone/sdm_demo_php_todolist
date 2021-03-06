<?php

// This code was generated by a tool. Don't modify it manually.
// http://sqldalmaker.sourceforge.net


include_once __DIR__ . '/Task.php';

class TasksDao
{
    protected $ds;

    public function __construct($ds)
    {
        $this->ds = $ds;
    }

    /**
     * (C)RUD: tasks
     * Generated values are passed to DTO.
     * @param Task $p
     * @return TRUE|FALSE on success|failure
     */
    public function create_task(Task $p)
    {
        $sql = "insert into tasks (g_id, t_priority, t_date, t_subject, t_comments) values (?, ?, ?, ?, ?)";
        $ai_values = array("t_id" => null);
        $res = $this->ds->insert($sql, array($p->get_g_id(), $p->get_t_priority(), $p->get_t_date(), $p->get_t_subject(), $p->get_t_comments()), $ai_values);
        $p->set_t_id($ai_values["t_id"]);
        return $res;
    }

    /**
     * C(R)UD: tasks
     * @param int $t_id
     * @return Task|FALSE on failure
     */
    public function read_task($t_id)
    {
        $sql = "select * from tasks where t_id=?";
        $row = $this->ds->queryRow($sql, array($t_id));
        if ($row) {
            $obj = new Task();
            $obj->set_t_id($row["t_id"]); // t <- t
            $obj->set_g_id($row["g_id"]); // t <- t
            $obj->set_t_priority($row["t_priority"]); // t <- t
            $obj->set_t_date($row["t_date"]); // t <- t
            $obj->set_t_subject($row["t_subject"]); // t <- t
            $obj->set_t_comments($row["t_comments"]); // t <- t
            return $obj;
        }
        return FALSE;
    }

    /**
     * CR(U)D: tasks
     * @param Task $p
     * @return int the affected rows count
     */
    public function update_task(Task $p)
    {
        $sql = "update tasks set g_id=?, t_priority=?, t_date=?, t_subject=?, t_comments=? where t_id=?";
        return $this->ds->execDML($sql, array($p->get_g_id(), $p->get_t_priority(), $p->get_t_date(), $p->get_t_subject(), $p->get_t_comments(), $p->get_t_id()));
    }

    /**
     * CRU(D): tasks
     * @param int $t_id
     * @return int the affected rows count
     */
    public function delete_task($t_id)
    {
        $sql = "delete from tasks where t_id=?";
        return $this->ds->execDML($sql, array($t_id));
    }

    /**
     * @param string $g_id
     * @return Task[]
     */
    public function getGroupTasks($g_id)
    {
        $sql = "select * from tasks where g_id =?"
            . "\n order by t_id";
        $res = array();
        $_map_cb = function ($row) use (&$res) {
            $obj = new Task();
            $obj->set_t_id($row["t_id"]); // t <- q
            $obj->set_g_id($row["g_id"]); // t <- q
            $obj->set_t_priority($row["t_priority"]); // t <- q
            $obj->set_t_date($row["t_date"]); // t <- q
            $obj->set_t_subject($row["t_subject"]); // t <- q
            $obj->set_t_comments($row["t_comments"]); // t <- q
            array_push($res, $obj);
        };
        $this->ds->queryRowList($sql, array($g_id), $_map_cb);
        return $res;
    }

}
