<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Type_model extends CI_Model
{
	protected $table = 'types';
	
	public function types()
	{
		return $this->db->select('title')
			->from($this->table)
			->get()
			->result();	
	}
}