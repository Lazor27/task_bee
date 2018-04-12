<?php

class Task extends Model {
    public function getList($page  = null, $itemsPerPage = null, $sort = null)
    {
        if ($page == null) {
            $sql = "SELECT * FROM task";
        }else {
            $count = $itemsPerPage;
            $ofset = ($page - 1) * $count;
            $sql = "SELECT * FROM task order by {$sort} LIMIT {$ofset} , {$count} ";
        }

        return $this->db->query($sql);
    }

    public function saveArticle($data, $id = null)
    {
        $name      = $this->db->escape($data['name']);
        $email       = $this->db->escape($data['email']);
        $description = $this->db->escape($data['description']);

        if (!$id ) { // add new record
            $sql = "
            INSERT INTO task
              SET name      = '{$name}',
                  email       = '{$email}',
                  description = '{$description}'
            ";}else { // update existing record
                            $sql = "
            UPDATE task
              SET name      = '{$name}',
                  description = '{$description}'
                WHERE id = '{$id}'
            ";
        }

        return $this->db->query($sql);
    }

    public function getID ()
    {
        $sql = "
        SELECT * 
          FROM task 
            ORDER BY id DESC
              LIMIT 1
        ";
        $result = $this->db->query($sql);
        return isset($result[0]) ? $result[0]['id'] : null;
    }

    public function getByID($id)
    {
        $id = $this->db->escape($id);
        $sql = "
            SELECT * 
              FROM task 
                WHERE id = '{$id}'
            ";
        $result = $this->db->query($sql);
        return isset($result[0]) ? $result[0] : null;
    }

    public function setDone($id)
    {
        $sql = "UPDATE task
              SET status = 1
                WHERE id = '{$id}'
            ";
        $this->db->query($sql);
    }
}