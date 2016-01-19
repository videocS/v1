<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Video_model extends CI_Model
{
	protected $table = 'videos';
	
	public function afficher($id)
	{
		return $this->db->select('*')
			->from($this->table)
			->where('id', $id)
			->get()
			->row();
	}

	public function ajouter($title, $description, $theme, $link, $type = NULL)
	{
		$this->db->set('title', $title);
		$this->db->set('description', $description);
		$this->db->set('link', $link);
		$this->db->set('themes', $theme);
		$this->db->set('type', $type);
		$this->db->set('state', '0');
		$this->db->set('id_member', $this->session->id);

		return $this->db->insert($this->table);
	}

	public function editer($id, $title, $description, $theme, $link, $type, $duration, $screen, $state, $more_details = NULL)
	{
		$this->db->set('title', $title);
		$this->db->set('description', $description);
		$this->db->set('link', $link);
		$this->db->set('themes', $theme);
		$this->db->set('type', $type);
		$this->db->set('state', $state);
		$this->db->set('screen', $screen);
		$this->db->set('duration', $duration);
		$this->db->set('more_details', $more_details);
		$this->db->where('id', $id);

		return $this->db->update($this->table);
	}

	public function supprimer($id)
	{
		return $this->db->where('id', $id)->delete($this->table);
	}


	public function aValider()
	{
		return $this->db->select(array('id', 'title', 'link', 'themes', 'description', 'type'))
			->from($this->table)
			->where('state', '0')
			->get()
			->result();
	}

	public function accepter($id)
	{
		$this->db->set('state', 1)
			->where('id', $id);
		return $this->db->update($this->table);
	}
	
	public function enAttente($id)
	{
		$this->db->set('state', 2)
			->where('id', $id)
			->where('state', '0');
		return $this->db->update($this->table);
	}

	public function refuser($id)
	{
		$this->db->where('id', $id)
			->where('state', '0');
		return $this->db->delete($this->table);
	}

	public function search($type, $theme, $order, $page, $search = NULL)
	{
		$this->db->select('*')
			->from($this->table)
			->where('state >=', 0);

		if($type != 1)
			$this->db->where('type', $type);

		if($theme != 1)
			$this->db->like('themes', $theme);

		if(isset($search))
			$this->db->like('title', $search);

		switch ($order) {
			case '1':
				$this->db->order_by('id', 'desc');
				break;
			case '2':
				$this->db->order_by('id', 'asc');
				break;									
			case '3':
				$this->db->order_by('id', 'desc');
				break;				
			default:
				break;
		}		

		$this->db->limit(VIDEOS_PER_PAGE, ceil(VIDEOS_PER_PAGE * ($page - 1)));

		return $this->db->get()
			->result();
	}

	public function totalSearch($type, $theme, $order, $search = NULL)
	{
		$this->db->select('id')
			->from($this->table)
			->where('state >=', 0);

		if($type != 1)
			$this->db->where('type', $type);

		if($theme != 1)
			$this->db->like('themes', $theme);

		if(isset($search))
			$this->db->like('title', $search);

		switch ($order) {
			case '1':
				$this->db->order_by('id', 'desc');
				break;
			case '2':
				$this->db->order_by('id', 'asc');
				break;									
			case '3':
				$this->db->order_by('id', 'desc');
				break;				
			default:
				break;
		}		
		return $this->db->get()->num_rows();
	}
}
