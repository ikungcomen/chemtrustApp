<?php

class DBhelper extends CI_Model {

    function login($username, $password) {
        $sql = "select * from tb_user where user_id = '" . $username . "' and user_pass = '" . $password . "' and user_status = 'A'";
        $query = $this->db->query($sql);
        return $query;
    }

    public function insert_cemee($chem_no, $chem_cas_number, $chem_seq, $chem_type, $chem_name_th, $chem_name_en, $chem_qty_in, $chem_qty_in_msm, $chem_qty_boh, $chem_qty_boh_msm, $chem_location, $user_id, $date) {
        $this->db->set('chem_no', $chem_no);
        $this->db->set('chem_cas_number', $chem_cas_number);
        $this->db->set('chem_seq', $chem_seq);
        $this->db->set('chem_type', $chem_type);
        $this->db->set('chem_name_th', $chem_name_th);
        $this->db->set('chem_name_en', $chem_name_en);
        $this->db->set('chem_qty_in', $chem_qty_in);
        $this->db->set('chem_qty_in_msm', $chem_qty_in_msm);
        $this->db->set('chem_qty_boh', $chem_qty_boh);
        $this->db->set('chem_qty_boh_msm', $chem_qty_boh_msm);
        $this->db->set('chem_location', $chem_location);
        $this->db->set('create_date', $date);
        $this->db->set('create_userid', $user_id);
        $this->db->set('update_date', $date);
        $this->db->set('update_userid', $user_id);
        $this->db->insert('tb_chem_info');
        if ($this->db->affected_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function getTb_chem_info($chem_no) {
        $sql = "select 	chem_no,chem_name_th  from tb_chem_info  where chem_no = '".$chem_no."'";
        $result = $this->db->query($sql);
        return $result->num_rows();
        
    }
    public function tb_msm_master() {
        $sql = "select 	*  from tb_msm_master order by chem_msm_no asc ";
        $result = $this->db->query($sql);
        $result = $result->result_array();
        return $result;
    }

    public function search_chem_no_auto($chem_no) {
        $sql = "select 	*  from tb_chem_info where chem_no like '%" . $chem_no . "%'";
        $result = $this->db->query($sql);
        $result = $result->result_array();
        return $result;
    }

    public function search_chem_name_auto($chem_name) {
        $sql = "select 	*  from tb_chem_info where chem_name_th like '%$chem_name%'";
        $result = $this->db->query($sql);
        $result = $result->result_array();
        return $result;
    }

    public function search_chem($chem_no, $chem_name) {
        $sqlWhere = "";
        if (trim($chem_no) != "") {
            $sqlWhere = $sqlWhere . " tci.chem_no = '$chem_no'";
        }
        if (trim($chem_name) != "") {
            if ($sqlWhere != "") {
                $sqlWhere = $sqlWhere . " and ";
            }
            $sqlWhere = $sqlWhere . " tci.chem_name_th = '$chem_name'";
        }
        if ($sqlWhere != "") {
            $sqlWhere = "where " . $sqlWhere;
        }
        $sql = " select chem_no as chem_no	"  ;
        $sql = $sql."   ,tci.chem_cas_number as chem_cas_number";
        $sql = $sql."   ,tci.chem_seq as chem_seq ";
        $sql = $sql."   ,tci.chem_name_th as chem_name_th ";
        $sql = $sql."   ,tci.chem_name_en as chem_name_en ";
        $sql = $sql."   ,tcs.chem_store_name as chem_type";
        $sql = $sql."   ,tci.chem_location as chem_location ";
        $sql = $sql."   ,tci.chem_qty_in as chem_qty_in ";
        $sql = $sql."   ,tci.chem_qty_in_msm as chem_qty_in_msm ";
        $sql = $sql."   ,tci.chem_qty_boh as chem_qty_boh ";
        $sql = $sql."   ,tci.chem_qty_boh_msm as chem_qty_boh_msm ";
        $sql = $sql."   ,tci.update_userid as update_userid ";
        $sql = $sql."   ,DATE_FORMAT(tci.update_date,'%d/%m/%Y') as update_date";
        $sql = $sql." from tb_chem_info tci ";
        $sql = $sql." left join tb_chem_store tcs on tci.chem_type  = tcs.chem_store_type ".$sqlWhere;
        $result = $this->db->query($sql);
        $result = $result->result_array();
        return $result;
    }
    public function delete_chem($chem_no){
        $this->db->where('chem_no', $chem_no);
        $this->db->delete('tb_chem_info');
        if ($this->db->affected_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }
    
    public function detai_chem($chem_no){
        $sql = "";
        $sql = " select chem_no as chem_no	"  ;
        $sql = $sql."   ,tci.chem_cas_number                     as chem_cas_number";
        $sql = $sql."   ,tci.chem_seq                            as chem_seq ";
        $sql = $sql."   ,tci.chem_name_th                        as chem_name_th ";
        $sql = $sql."   ,tci.chem_name_en                        as chem_name_en ";
        $sql = $sql."   ,tci.chem_type                           as chem_type ";
        $sql = $sql."   ,tcs.chem_store_name                     as chem_store_name ";
        $sql = $sql."   ,tci.chem_location                       as chem_location ";
        $sql = $sql."   ,tci.chem_qty_in                         as chem_qty_in ";
        $sql = $sql."   ,tci.chem_qty_in_msm                     as chem_qty_in_msm ";
        $sql = $sql."   ,tci.chem_qty_boh                        as chem_qty_boh ";
        $sql = $sql."   ,tci.chem_qty_boh_msm                    as chem_qty_boh_msm ";
        $sql = $sql."   ,tci.update_userid                       as update_userid ";
        $sql = $sql."   ,tcw.chem_warehouse_name                 as chem_warehouse_name ";
        $sql = $sql."   ,DATE_FORMAT(tci.update_date,'%d/%m/%Y') as update_date";
        $sql = $sql."   ,(select chem_msm_name from tb_msm_master where chem_msm_no = tci.chem_qty_in_msm)  as chem_msm_name_in ";
        $sql = $sql."   ,(select chem_msm_name from tb_msm_master where chem_msm_no = tci.chem_qty_boh_msm) as chem_msm_name_out";
        $sql = $sql." from tb_chem_info tci ";
        $sql = $sql." left join tb_chem_store tcs on tci.chem_type  = tcs.chem_store_type ";
        $sql = $sql." left join tb_chem_warehouse tcw on tcw.chem_warehouse_code  = tci.chem_location ";
        $sql = $sql."where chem_no = '".$chem_no."'";
        $result = $this->db->query($sql);
        $result = $result->result_array();
        return $result;
    }
     public function get_chem_classify($chem_no){
        //xxxx
    }

}

?>