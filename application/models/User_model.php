<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model
{
	protected $table = 'users';

	public function verif_connect($username)
	{
		return $this->db->select(array('id', 'username', 'password', 'rank'))
			->from($this->table)
			->where('username', $username)
			->get()
			->row();
	}
	
	public function inscription($pseudo, $mdp, $email, $newsletter)
	{
		$this->db->set('username', $pseudo)
			->set('password', $mdp)
			->set('email', $email)
			->set('newsletter', $newsletter)
			->set('rank', '1');
		return $this->db->insert($this->table);
	}

	public function dataMember($id)
	{
		return $this->db->select('*')
			->from($this->table)
			->where('id', $id)
			->get()
			->row();
	}

	public function edit($id, $newsletter, $email, $pseudo, $rank, $password = null)
	{
		$this->db->set('email', $email)
			->set('newsletter', $newsletter);

		if($password != null)
		{
			$this->db->set('password', password_hash($password, PASSWORD_BCRYPT));
		}
		if($pseudo != null && $this->session->rank >= MODERATEUR)
		{
			$this->db->set('username', $pseudo);
		}
		if($this->session->rank == ADMINISTRATEUR)
		{
			$this->db->set('rank', $rank);
		}

		$this->db->where('id', $id)
			->update($this->table);
	}

	public function unsuscribe($id)
	{
		return $this->db->where('id', $id)
			->delete($this->table);
	}

	public function liste()
	{
		return $this->db->select(array('id', 'username'))
			->from($this->table)
			->order_by('username', 'asc')
			->get()
			->result();
	}

	public function liste_email()
	{
		return $this->db->select('email')
			->from($this->table)
			->where('newsletter', 1)
			->get()
			->result();
	}
}
