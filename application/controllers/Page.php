<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends MY_Controller{
	
	public function accueil()
	{
		redirect('accueil');
	}

	public function show($slug)
	{
		$this->load->model('page_model', 'page');
		$this->load->helper('BBCode');
		$page = $this->page->afficher($slug);
		if($page)
		{
			$this->layout->set_titre($page->title);
			$this->layout->view('page/page', compact('page'));
		}
		else
		{
			show_404();
		}
	}

	public function edit($slug)
	{
		if($this->session->rank < MODERATEUR)
			show_404();

		$this->load->library('form_validation');
		$this->load->model('page_model', 'page');
		$this->load->model('tracker_model', 'tracker');
		$page = $this->page->afficher($slug);
		if(!$page)
			show_404();


		$valid = '';
		if($this->input->post('title') != $page->title)
		{
			$valid = '|is_unique[pages.title]';
		}
		$this->form_validation->set_rules('title', 'titre', 'required'.$valid);
		$this->form_validation->set_rules('content', 'contenu', 'required');
		$this->form_validation->set_rules('menu', 'apparaitre dans le menu', 'required|is_numeric');

		if($this->form_validation->run())
		{
			$this->page->edit($this->input->post('content'), $this->input->post('menu'), $slug);
			$this->tracker->add('Edition de la page <a href="'.base_url($slug).'">'.$this->input->post('title').'</a>');
			$this->session->set_flashdata('success', 'Page éditée avec succès.');
			redirect('admin/pages');
		}
		else
		{
			$this->layout->view('page/edit', ['errors' => $this->form_validation->error_array(), 'page' => $page]);
		}
	}

	public function delete($slug)
	{
		if($this->session->rank < MODERATEUR)
			show_404();
		$this->load->model('page_model', 'page');
		$this->load->model('tracker_model', 'tracker');		
		$this->page->delete($slug);
		$this->tracker->add('Supression de la page auparavent accessible à l\'adresse '.base_url($slug));
		$this->session->set_flashdata('success', 'Page supprimée avec succès.');
		redirect('admin/pages');		
	}
}