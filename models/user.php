<?php

class User extends Model {
    public function getByLogin($login)
    {
        $login = $this->db->escape($login);
        $sql = "select * from user where login = '{$login}' limit 1";
        $result = $this->db->query($sql);
        if (isset($result[0])) {
            return $result[0];
        }
        return false;
    }

    public function registerUser($first_name, $last_name, $login, $email, $password, $date)
    {
        $first_name = $this->db->escape($first_name);
        $last_name  = $this->db->escape($last_name);
        $login      = $this->db->escape($login);
        $email      = $this->db->escape($email);
        $password   = $this->db->escape($password);
        $sql = "
            INSERT INTO user (first_name, last_name, login, email, password, date_of_birth) 
              VALUES ('{$first_name}', '{$last_name}', '{$login}', '{$email}', '{$password}', '{$date}')
            ";
        return $this->db->query($sql);
    }

    public function getByEmail($email)
    {
        $email = $this->db->escape($email);
        $sql = "
            SELECT * 
              FROM user 
                WHERE email = '{$email}'
            ";
        $result = $this->db->query($sql);
        if (isset($result[0])) {
            return $result[0];
        }
        return false;
    }
}