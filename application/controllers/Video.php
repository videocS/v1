<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Video extends MY_Controller{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('video_model', 'video');
		$this->load->model('tracker_model', 'tracker');
	}
	public function add()
	{
		if($this->session->id <= 0)
			show_404();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('title', 'titre', 'required');
		$this->form_validation->set_rules('description', 'description', 'required');
		$this->form_validation->set_rules('theme', 'thème', 'required');
		$this->form_validation->set_rules('link', 'lien', 'required|is_unique[videos.link]');

		if($this->form_validation->run())
		{
			$theme = $this->input->post('theme') != $this->input->post('theme_bis') ? $this->input->post('theme')."-".$this->input->post('theme_bis') :  $this->input->post('theme')."-";
			$this->video->ajouter($this->input->post('title'), $this->input->post('description'), $theme, $this->input->post('link'), $this->input->post('type'));

			$this->load->library('email');
			$this->email->from('Mail automatique');
			$this->email->to(EMAIL_WEBMASTER);
			$this->email->message('Bonjour,

				Le membre <a href="'.base_url('user/show/'.$this->session->id).'">'.$this->session->username.'</a> vient de proposer la vidéo '.htmlspecialchars($this->input->post('title')).'.
				Connectez-vous sur votre compte pour traiter cette demande.');
			$this->email->send();
			$this->session->set_flashdata('success', 'La vidéo proposée est maintenant en attente de validation. Elle sera publiée d\'ici peu.');
			$this->tracker->add('Proposition de la vidéo "'.$this->input->post('title').'"');
			redirect('video/add');
		}
		else
		{
			$this->load->model('type_model', 'type');
			$this->load->model('theme_model', 'theme');

			$themes = $this->theme->themes();
			$types = $this->type->types();
			$this->layout->view('video/ajouter', ['errors' => $this->form_validation->error_array(), 'types' => $types, 'themes' => $themes]);
		}

	}

	public function search($page = 1)
	{
		$this->load->library('form_validation');
		$this->load->model('type_model', 'type');
		$this->load->model('theme_model', 'theme');

		$themes = $this->theme->themes();
		$types = $this->type->types();
		
		$this->load->library('pagination');
 
		$config['base_url'] = base_url().'/video/search/';
		$config['per_page'] = VIDEOS_PER_PAGE;
		
		if($this->input->get('order') || $this->input->get('type') || $this->input->get('theme'))
		{
 			$config['total_rows'] = $this->video->totalSearch($this->input->get('type'), $this->input->get('theme'), $this->input->get('order'), $this->input->get('search'));
			if ($page < 1)
			{
				$page = 1;
			}
			elseif ($page > ceil($config['total_rows'] / VIDEOS_PER_PAGE))
			{
				$page = ceil($config['total_rows'] / VIDEOS_PER_PAGE);
			}
			$this->pagination->initialize($config);
			$videos = $this->video->search($this->input->get('type'), $this->input->get('theme'), $this->input->get('order'), $page, $this->input->get('search'));
			$this->layout->view('video/rechercher', ['types' => $types, 'themes' => $themes, 'videos' => $videos, 'pagination' => $this->pagination->create_links()]);
		}
		else
		{
			$config['total_rows'] = $this->video->totalSearch(1, 1, 1);
			if ($page < 1)
			{
				$page = 1;
			}
			elseif ($page > ceil($config['total_rows'] / VIDEOS_PER_PAGE))
			{
				$page = ceil($config['total_rows'] / VIDEOS_PER_PAGE);
			}
			$this->pagination->initialize($config);
			$videos = $this->video->search(1, 1, 1, 1);
			$this->layout->view('video/rechercher', ['types' => $types, 'themes' => $themes, 'videos' => $videos, 'pagination' => $this->pagination->create_links()]);
		}
	}

	public function show($id)
	{
		$video = $this->video->afficher($id);

		$this->load->model('vote_model', 'vote');
		$vote = $this->vote->verif($id, $this->session->id);

		if($video)
		{	
			$this->layout->view('video/afficher', ['video' => $video, 'vote' => $vote]);
		}
		else
		{
			show_404();
		}
	}

	public function delete($id)
	{
		if($this->session->rank < MODERATEUR)
		{
			show_404();
		}
		else
		{
			$this->video->supprimer($id);
			$this->session->set_flashdata('success', 'Vidéo supprimée avec succès.');
			$this->tracker->add('Suppression de la vidéo n°'.$id);
			redirect(base_url(''));
		}
	}

	public function edit($id)
	{
		if($this->session->rank < MODERATEUR)
			show_404();


		$this->load->library('form_validation');
		$this->form_validation->set_rules('title', 'titre', 'required');
		$this->form_validation->set_rules('description', 'description', 'required');
		$this->form_validation->set_rules('theme', 'thème', 'required');
		$this->form_validation->set_rules('link', 'lien', 'required');
		$this->form_validation->set_rules('duration', 'durée', 'required');
		$this->form_validation->set_rules('type', 'type', 'required');
		$this->form_validation->set_rules('screen', 'impression d\'écran', 'required');
		$this->form_validation->set_rules('state', 'statut', 'required|is_numeric');

		if($this->form_validation->run())
		{
			$theme = $this->input->post('theme') != $this->input->post('theme_bis') ? $this->input->post('theme')."-".$this->input->post('theme_bis') :  $this->input->post('theme')."-";
			$this->video->editer($id, $this->input->post('title'), $this->input->post('description'), $theme, $this->input->post('link'), $this->input->post('type'), $this->input->post('duration'), $this->input->post('screen'), $this->input->post('state'), $this->input->post('more_details'));
			
			$this->session->set_flashdata('success', 'La fiche de la vidéo a bien été éditée.');
			redirect('video/show/'.$id);
		}
		else
		{
			$this->load->model('type_model', 'type');
			$this->load->model('theme_model', 'theme');

			$themes = $this->theme->themes();
			$types = $this->type->types();
			$video = $this->video->afficher($id);
			if($video)
				$this->layout->view('video/editer', ['errors' => $this->form_validation->error_array(), 'types' => $types, 'themes' => $themes, 'video' => $video]);
			else
				show_404();
		}	
	}

	public function voter($id_video, $id_member, $value)
	{
		$this->load->model('vote_model', 'vote');
		$video = $this->video->afficher($id_video);
		$vote = $this->vote->verif($id_video, $id_member);
		if($id_member != $this->session->id || ($value != 1 && $value != 2) || empty($video) || isset($vote))
		{
			show_404();
		}
		else
		{
			$this->vote->ajouter($id_video, $value);
			if($value == 2)
			{
				if($this->vote->nbNegatifs($id_video) >= NB_VOTES)
				{
					$this->video->supprimer($id_video);
					$this->session->set_flashdata('success', 'Votre vote a été comptabilité. La vidéo a été jugée inapropriée par la communauté et n\'apparait plus sur le site.');
					$this->tracker->add('Vote négatif de la vidéo n°'.$id_video.'. Vidéo non acceptée après '.NB_VOTES.' négatifs.');
					redirect(base_url(''));
				}
			}
			elseif($value == 1)
			{
				if($this->vote->nbPositifs($id_video) >= NB_VOTES)
				{
					$this->video->accepter($id_video);
					$this->session->set_flashdata('success', 'Votre vote a été comptabilité. La vidéo a été acceptée par la communauté et est maintenant validée.');
					$this->tracker->add('Vote positif de la vidéo n°'.$id_video.'. Vidéo  acceptée après '.NB_VOTES.' positifs.');
					redirect('video/show/'.$id_video);
				}
			}
			$this->session->set_flashdata('success', 'Votre vote a été comptabilité.');
			$this->tracker->add('Vote de la vidéo n°'.$id_video);
			redirect('video/show/'.$id_video);
		}
	}
}