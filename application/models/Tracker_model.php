<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tracker_model extends CI_Model
{
	protected $table = 'logs';

	public function add($action)
	{
		$this->db->set('id_author', $this->session->id != NULL ? $this->session->id : $this->db->insert_id())
			->set('action', $action)
			->set('done_at', date('Y-m-d H:i'));
		return $this->db->insert($this->table);
	}

	public function aValider()
	{
		return $this->db->select($this->table.'.action, '.$this->table.'.done_at, users.username')
        				->from($this->table)
				        ->join('users', $this->table.'.id_author = users.id')
				        ->where('confirmed_by', NULL)
				        ->order_by('done_at', 'desc')
				        ->get()
				        ->result();
	}

	public function supprimer()
	{
		return $this->db->where('done_at <= ', date('Y-m-d H:i:s', strtotime('-4 days')))
						->delete($this->table);
	}

	public function accept()
	{
		return $this->db->set('confirmed_by', $this->session->id)
						->where('confirmed_by', NULL)
						->update($this->table);
	}
}
