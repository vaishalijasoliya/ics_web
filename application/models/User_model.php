<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

//**---FOR INSERT DATA
    public function INSERTDATA($tablename, $feild = '') {

        if (!empty($tablename) || !empty($feild)):

            $this->db->set($feild);

            $insert = $this->db->insert($tablename);

            if ($insert):

                return $this->db->insert_id();

            endif;

        else: return "Invalid Input Provided";

        endif;
    }
//**---FOR UPDATE DATA
    public function UPDATEDATA($tablename, $where = '', $feild = '') {

        if (!empty($tablename) || !empty($feild)):

            $this->db->where($where);

            $this->db->update($tablename, $feild);

			return TRUE;

        else: return FALSE;

        endif;
    }
//**---FOR DELETE DATA
    public function DELETEDATA($tablename = '', $where = '') {

        if (!empty($tablename) || !empty($where)):

            $this->db->where($where);

            $this->db->delete($tablename);

        return TRUE;

        else: return FALSE;


        endif;
    }
//**---FOR SELECT DATA
    public function get_sql_select_data($tablename = '', $where = '', $order_by = '', $where_not='', $feild = '', $limit = '', $like = '') {

        if (!empty($feild))
            $this->db->select($feild);

        if (empty($feild))
            $this->db->select();

        if (!empty($where))
            $this->db->where($where);

        if (!empty($limit))
            $this->db->limit($limit);

		if (!empty($where_not))
            $this->db->where_not_in($where_not);

        if (!empty($like))
            $this->db->like($like);

        if (!empty($order_by))
            $this->db->order_by($order_by);

        $this->db->from($tablename);
        $query = $this->db->get();
        return $query->result_array();
    }

//**---JOIN DATA
    public function get_joins($tablename = '', $where = '', $joins = '', $columns = '', $like = '', $group_by = '', $order_by = '', $limit = '', $start = '', $where_or = '') {


        if(!empty($columns))$this->db->select($columns);
        if(empty($columns))$this->db->select('*');

        if (is_array($joins) && count($joins) > 0) {
            foreach ($joins as $k => $v) {
                $this->db->join($v['table'], $v['condition'], $v['jointype']);
            }
        }

        if (!empty($group_by))
            $this->db->group_by($group_by);

        if (!empty($like))
            $this->db->or_like($like);

        if (!empty($limit))
            $this->db->limit($limit, $start);

        if (!empty($where))
            $this->db->where($where);

        if (!empty($order_by))
            $this->db->order_by($order_by);

        if (!empty($where_or))
            $this->db->or_where($where_or);

            $this->db->from($tablename);

        $query = $this->db->get();
        return $query->result_array();

    }


 function getSumOfValues($tbl_nm,$startdate,$enddate,$coulamNm,$columnval,$noSum,$type){

		   foreach($noSum as $k=>$v)
					$query = $this->db->select_avg($k,$v);


			 $this->db->where('date_time >="'.$startdate.'" AND date_time <="'.$enddate.'" AND '.$coulamNm.'="'.$columnval.'"');

			 $query = $this->db->get($tbl_nm);

			if($type == '1'){
			$sumData = array_shift($query->result_array());


							$sumByCOMs = '';
							$c = 1;
							foreach($noSum as $k=>$v){
								if($c == 1){
							  $sumByCOMs =  round($sumData[$v]);
								}else{
							  $sumByCOMs = $sumByCOMs.','.round($sumData[$v]);
								}

							$c++;}

							return $sumByCOMs;


			}else
			 return $query->result_array();

 }


function get_max_value($tbl_nm = "",$maxfields = "",$where = "",$group_by = ""){

	 foreach($maxfields as $k=>$v)
			$this->db->select_max($k,$v);


	 if (!empty($group_by))
            $this->db->group_by($group_by);


	 if (!empty($where))
            $this->db->where($where);


	 $this->db->from($tbl_nm);


         $query = $this->db->get();


	 return array_shift($query->result_array());
}

public function get_entries($limit, $start)
{
  $this->db->limit($limit, $start);
  $query = $this->db->get("entries");
  return $query->result();
}
  public function get_count()
 {
       return $this->db->count_all("entries");
 }
 public function update_model($id,$data)
{

$sql = 'UPDATE tbl_meter_reading LEFT JOIN tbl_meter_connections ON tbl_meter_reading.meter_id=tbl_meter_connections.id SET remaining=remaining+'.$data.' WHERE water_right ='.$id;

$query=$this->db->query($sql);

    return ($this->db->affected_rows() > 0);

}
public function update_water_right($id,$volume)
{

$sql = 'UPDATE tbl_water_right_alloc SET wr_volume=wr_volume+'.$volume.' WHERE id ='.$id;

$query=$this->db->query($sql);

   return ($this->db->affected_rows() > 0);

}
}
