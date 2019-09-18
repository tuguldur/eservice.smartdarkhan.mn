<?php

class Home_model extends CI_Model {

    private $primary_key;
    private $main_table;
    public $errorCode;
    public $errorMessage;

    public function __construct() {
        parent::__construct();
        $this->main_table = "app_customer";
        $this->primary_key = "ID";
    }

    public function insert($data) {
        $this->db->insert('app_customer', $data);
        $id = $this->db->insert_ID();
        return $id;
    }

    function insertData($tbl = '', $data = array()) {
        if ($tbl == '') {
            $tbl = $this->main_table;
        }

        $this->db->insert($tbl, $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function insert_data($tbl, $data) {
        $this->db->insert('app_submit_request', $data);
        $id = $this->db->insert_ID();
        return $id;
    }

    public function edit($id, $data) {
        $this->db->where('ID', $id);
        $this->db->update('app_customer', $data);
    }

    public function update_data($tbl, $cond, $data) {
        $this->db->where($cond, false, false);
        $this->db->update($tbl, $data);
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
        if ($orderby != "") {
            $this->db->order_by($orderby, false);
        }
        if (trim($climit) != '') {
            $this->db->limit($climit);
        }if (is_array($like) && count($like) > 0) {
            foreach ($like as $ky => $vl) {
                $this->db->like($vl['column'], $vl['pattern']);
            }
        }
        if ($tbl != '') {
            $this->db->from($tbl);
        } else {
            $this->db->from($this->main_table);
        }
        $list_data = $this->db->get()->result_array();
        return $list_data;
    }

    function getSingleRow($tbl, $condition) {
        $this->db->select("*", false);
        $this->db->from($tbl);
        $this->db->where($condition, false, false);
        return $this->db->get()->row_array();
    }

    function getTotalView($tbl, $condition) {
        $this->db->select("*", false);
        $this->db->where($condition, false, false);
        $query = $this->db->get($tbl);
        return $query->num_rows();
    }

}

?>