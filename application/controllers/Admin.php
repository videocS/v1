<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Controller{
	
	public function __construct()
	{
		parent::__construct();
		if($this->session->rank < MODERATEUR)
		{
			redirect(base_url('administration-de-videoc'));
		}
	}

	public function members()
	{
		$this->load->model('user_model', 'user');
		$members = $this->user->liste();
		$this->layout->view('admin/membres', compact('members'));
	}

	public function newsletter()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('title', 'titre', 'required');
		$this->form_validation->set_rules('content', 'message', 'required');

		if($this->form_validation->run())
		{
			$this->load->model('user_model', 'user');
			$this->load->model('tracker_model', 'tracker');
			$email = $this->user->liste_email();
			$this->load->library('email');
			foreach($email as $contact)
			{
				$this->email->from(EMAIL_WEBMASTER, NAME_SITE);
				$this->email->to($contact->email);
				$this->email->subject(NAME_SITE.' | '.$this->input->post('title'));
				$this->email->message($this->input->post('content')."
					_________________
					Vous pouvez à tout moment vous désincrire de cette newsletter dans votre profil ".NAME_SITE.".");
				$this->email->send();	
			}
			$this->tracker->add('Envoi d\'une newsletter');
			$this->session->set_flashdata('success', 'La newsletter a bien été envoyée');
			redirect('admin/newsletter');
		}
		else
		{
			$this->layout->view('admin/newsletter', ['errors' => $this->form_validation->error_array()]);
		}
	}

	public function pages()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('title', 'titre', 'required|is_unique[pages.title]');
		$this->form_validation->set_rules('content', 'contenu', 'required');
		$this->form_validation->set_rules('menu', 'apparaitre dans le menu', 'required|is_numeric');
			
		$this->load->model('page_model', 'page');
		$this->load->model('tracker_model', 'tracker');

		if($this->form_validation->run())
		{
			$this->load->helper('slug');
			$slug = strtoslug($this->input->post('title'));
			$this->page->insert($this->input->post('title'), $slug, $this->input->post('content'), $this->input->post('menu'));
			$this->tracker->add('Ajout de la page <a href="'.base_url($slug).'">'.$this->input->post('title').'</a>');
			$this->session->set_flashdata('success', 'Page ajoutée avec succès.');
			redirect('admin/pages');
		}
		else
		{
			$pages = $this->page->liste();
			$this->layout->view('admin/pages', ['errors' => $this->form_validation->error_array(), 'pages' => $pages]);
		}
	}

	public function videos($id = 0, $etat = 0)
	{
		$this->load->model('video_model', 'video');
		$this->load->model('tracker_model', 'tracker');
		if($id == 0)
		{
			$videos = $this->video->aValider();
			$this->layout->view('admin/videos', compact('videos'));
		}
		else
		{
			switch ($etat) 
			{
				case '1':
					$this->video->accepter($id);
					$this->tracker->add('Acceptation d\'<a href="'.base_url('video/show/'.$id).'">une vidéo</a>');
					redirect('video/edit/'.$id);
					break;
				case '2':
					$this->video->enAttente($id);
					$this->tracker->add('Acceptation d\'<a href="'.base_url('video/show/'.$id).'">une vidéo</a> "à l\'essai"');
					redirect('video/edit/'.$id);
					break;
				case '3':
					$this->video->refuser($id);
					$this->tracker->add('Refus d\'une vidéo');
					break;
				default:
					break;
			}
			$this->session->set_flashdata('Traitement de la vidéo validé.');
			redirect('admin/videos');
		}

	}

	public function logs($action = NULL)
	{
		$this->load->model('tracker_model', 'tracker');
		$this->tracker->supprimer();
		if($action != NULL)
		{
			$this->tracker->accept();
			$this->session->set_flashdata('Historique validé avec succès.');
			redirect('admin/logs');			
		} 
		else 
		{
			$logs = $this->tracker->aValider();
			$this->layout->view('admin/logs', compact('logs'));
		}
	}
}