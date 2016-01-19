<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page_model extends CI_Model
{
	protected $table = 'pages';

	public function liste()
	{
		return $this->db->select(array('id', 'title', 'slug', 'menu'))
			->from($this->table)
			->get()
			->result();
	}

	public function insert($title, $slug, $content, $menu)
	{
		$this->db->set('title', $title)
			->set('slug', $slug)
			->set('content', $content)
			->set('menu', $menu);

		return $this->db->insert($this->table);
	}

	public function afficher($slug)
	{
		return $this->db->select(array('title', 'content', 'menu'))
			->from($this->table)
			->where('slug', $slug)
			->get()
			->row();
	}

	public function pageMenu()
	{
		return $this->db->select(array('id', 'slug', 'title'))
			->from($this->table)
			->where('menu', '1')
			->get()
			->result();
	}

	public function edit($content, $menu, $slug)
	{
		$this->db->set('content', $content)
			->set('menu', $menu)
			->where('slug', $slug);

		return $this->db->update($this->table);
	}

	public function delete($slug)
	{
		$this->db->where('slug', $slug);
		return $this->db->delete($this->table);
	}
}
