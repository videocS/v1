<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Theme_model extends CI_Model
{
	protected $table = 'themes';
	
	public function themes()
	{
		return $this->db->select('title')
			->from($this->table)
			->get()
			->result();
	}
}
