<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ListDataModel extends CI_Model {

	public function __construct()
	{
	  parent::__construct();
	}

	private function _get_datatables_query($column_search, $column_order, $order)
	  {
	      $sql = "";
	      $i = 0;
	   
	      foreach ($column_search as $item) // loop column 
	      {
	          if($_POST['search']['value']) // if datatable send POST for search
	          {
	               
	              if($i===0) // first loop
	              {
	                  $sql.=" AND ( ";
	                  $sql.=$item." LIKE '%".$_POST['search']['value']."%'";
	              }
	              else
	              {
	                  $sql.=" OR ".$item." LIKE '%".$_POST['search']['value']."%'";
	              }

	              if(count($column_search) - 1 == $i) //last loop
	                  $sql.=" ) ";
	          }
	          $i++;
	      }
	       
	      if(isset($_POST['order'])) // here order processing
	      {
	          $sql.= " ORDER BY ".$column_order[$_POST['order']['0']['column']]." ".$_POST['order']['0']['dir'];
	      } 
	      else if(isset($order))
	      {
	          $sql.= " ORDER BY ".key($order)." ".$order[key($order)];
	      }
	      return $sql;
	  }

	  function get_datatables($sql, $column_search, $column_order, $order)
	  {
	      $sql.= $this->_get_datatables_query($column_search, $column_order, $order);
	      if($_POST['length'] != -1)
	      $sql.= " LIMIT ".$_POST['start'].",".$_POST['length'];
	      $query = $this->db->query($sql);
	      return $query->result();
	  }

	  function count_filtered($sql, $column_search, $column_order, $order)
	  {
	      $sql.= $this->_get_datatables_query($column_search, $column_order, $order);
	      $query = $this->db->query($sql);
	      return $query->num_rows();
	  }

	  public function count_all($sql)
	  {
	      $query = $this->db->query($sql);
	      return $query->num_rows();
	  }

	}

/* End of file ListDataModel.php */
/* Location: ./application/models/ListDataModel.php */