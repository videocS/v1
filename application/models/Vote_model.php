<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vote_model extends CI_Model
{
	protected $table = 'votes';
	
	public function verif($id_video, $id_member)
	{
		return $this->db->select('id')
			->from($this->table)
			->where('id_video', $id_video)
			->where('id_member', $id_member)
			->get()
			->row();
	}

	public function ajouter($id_video, $value)
	{
		$this->db->set('id_member', $this->session->id)
			->set('id_video', $id_video)
			->set('value', $value);
		return $this->db->insert($this->table);
	}

	public function nbNegatifs($id_video)
	{
		return $this->db->query('SELECT id FROM votes WHERE id_video = '.$id_video.' && value = 2')->num_rows();
	}	

	public function nbPositifs($id_video)
	{
		return $this->db->query('SELECT id FROM votes WHERE id_video = '.$id_video.' && value = 1')->num_rows();
	}
}
