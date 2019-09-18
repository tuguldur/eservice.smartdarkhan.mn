<?php

class Model_dashboard extends CI_Model {

    private $primary_key;
    private $main_table;
    public $errorCode;
    public $errorMessage;

    public function __construct() {
        parent::__construct();
        $this->main_table = "app_customer";
        $this->primary_key = "ID";
    }

    public function authenticate($username, $password) {
        $ext = 'Password = "' . $password . '" AND  Username = "' . $username . '"';
        $this->db->select('*');
        $this->db->from($this->main_table);
        $this->db->where($ext);
        $result = $this->db->get();
        $record = $result->result_array();
        if (is_array($record) && count($record) > 0) {

            $this->session->set_userdata("ID", $record[0]["ID"]);
            $this->session->set_userdata("UNAME", $record[0]["Username"]);
            $this->session->set_userdata("FNAME", $record[0]["Firstname"]);
            $this->session->set_userdata("LNAME", $record[0]["Lastname"]);
            $this->session->set_userdata("EMAIL", $record[0]["Email"]);

            $this->errorCode = 1;
        } else {
            $this->errorCode = 0;
            $this->errorMessage = 'Please check your Username or Password and try again.';
        }

        $error['errorCode'] = $this->errorCode;
        $error['errorMessage'] = $this->errorMessage;

        return $error;
    }

    function insert($tbl = '', $data = array()) {
        if ($tbl == '') {
            $tbl = $this->main_table;
        }

        $this->db->insert($tbl, $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function delete($table, $id) {
        $this->db->where('id', $id);
        $del = $this->db->delete($table);
        return $del;
    }

    function update($tbl = '', $data = array(), $where = '') {
        if ($tbl == '') {
            $tbl = $this->main_table;
        }
        $this->db->where($where, false, false);
        $res = $this->db->update($tbl, $data);
        $rs = $this->db->affected_rows();
        return $rs;
    }

    function getData($tbl = '', $fields, $join_ary = array(), $condition = '', $orderby = '', $groupby = '', $having = '', $climit = '', $paging_array = array(), $reply_msgs = '', $like = array()) {

        if ($fields == '') {
            $fields = "*";
        }
        $this->db->select($fields, false);
        if (is_array($join_ary) && count($join_ary) > 0) {
            foreach ($join_ary as $ky => $vl) {
                $this->db->join($vl['table'], $vl['condition'], $vl['jointype']);
            }
        }
        if (trim($condition) != '') {
            $this->db->where($condition, false, false);
        }
        if (trim($groupby) != '') {
            $this->db->group_by($groupby);
        }
        if (trim($having) != '') {
            $this->db->having($having, false);
        }
        if ($orderby != '' && is_array($paging_array) && count($paging_array) == "0") {
            $this->db->order_by($orderby, false);
        }
        if (trim($climit) != '') {
            $this->db->limit($climit);
        }
        if ($tbl != '') {
            $this->db->from($tbl);
        } else {
            $this->db->from($this->main_table);
        }
        $list_data = $this->db->get()->result_array();
        return $list_data;
    }

    function Totalcount($table, $condition = '') {
        $this->db->select('*');
        if (trim($condition) != '') {
            $this->db->where($condition, false, false);
        }
        $total = $this->db->get($table)->num_rows();
        return $total;
    }

    function query($sql, $type = "") {

        $data = $this->db->query($sql);
        if ($type == '')
            $data = $data->result_array();
        return $data;
    }

    function getRecordData($tbl = '', $id = '', $field = '') {
        $this->db->select('*');
        $this->db->from($tbl);
        if ($id != '') {
            $this->db->where($field, $id);
        }
        $data = $this->db->get()->result_array();
        return $data;
    }

    function delete_fields($where = '') {
        if ($tbl == '') {
            $tbl = $this->main_table;
        }
        $this->db->where($where);
        $this->db->delete("custom_fields");
        return 'deleted';
    }

    function insert_fields($data = array()) {
        if ($tbl == '') {
            $tbl = $this->main_table;
        }

        $this->db->insert("custom_fields", $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    function getTimeZone() {
        $this->db->select('*');
        $this->db->from("time_zone_master");
        $result = $this->db->get()->result_array();

        return $result;
    }

}
