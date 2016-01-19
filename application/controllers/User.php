<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller{
	
	public function __construct()
	{
		parent::__construct();
		if($this->session->rank < MEMBRE)
		{
			$this->session->set_flashdata('error', 'Vous devez être connecté pour accéder à cette page');
			redirect(base_url(''));
		}

		$this->load->model('user_model', 'user');
		$this->load->model('tracker_model', 'tracker');
		$this->load->library('form_validation');
	}

	public function show($id = 0)
	{
		if(empty($id) || !is_numeric($id))
		{
			show_404();
		}
		$user = $this->user->dataMember($id);
		if($user != null)
		{
			$this->layout->set_titre($user->username);
			$this->layout->view('user/profil', compact('user'));
		}
		else
		{
			show_404();
		}
	}

	public function unsuscribe()
	{
		$this->form_validation->set_rules('confirm', 'confirm', 'required');

		if($this->form_validation->run())
		{
			$this->user->unsuscribe($this->session->id);
			$this->tracker->add('Désinscription de <a href="'.base_url('user/'.$this->session->id).'">'.$this->session->username.'</a>');
			redirect('auth/logout');
		}
		else
		{
			$this->layout->view('user/unsuscribe');
		}
	}

	public function edit($id = null)
	{
		if($id == null || $this->session->rank < MODERATEUR)
		{
			$id = $this->session->id;
		}
		$user = $this->user->dataMember($id);

		$usernameUnique = '';
		if($user->username != $this->input->post('username'))
			$usernameUnique = '|is_unique[users.username]';

		$emailUnique = '';
		if($user->email != $this->input->post('email'))
			$emailUnique = '|is_unique[users.email]';

		$this->form_validation->set_rules('username', 'nom d\'utilisateur', 'required'.$usernameUnique);
		$this->form_validation->set_rules('email', 'adresse e-mail', 'required|valid_email'.$emailUnique);
		$rank = empty($this->input->post('rank')) ? 1 : $this->input->post('rank');
		
		if($this->form_validation->run())
		{
			$newsletter = ($this->input->post('newsletter') == 1) ? 1 : 0;
			if(empty($this->input->post('password')))
			{
				$this->user->edit($id, $newsletter , htmlspecialchars($this->input->post('email')), htmlspecialchars($this->input->post('username')), $rank);
			}
			elseif($this->input->post('password') == $this->input->post('password_confirm'))
			{
				$this->user->edit($id, $newsletter, htmlspecialchars($this->input->post('email')), htmlspecialchars($this->input->post('username')), $rank, $this->input->post('password'));
			}
			else
			{
				$this->session->set_flashdata('error', 'Les deux mots de passe doivent être identiques.');
				redirect('user/edit/'.$id);				
			}
				$this->session->set_flashdata('success','Profil modifié avec succès.');
				$this->tracker->add('Edition du profil de <a href="'.base_url('user/show/'.$id).'">'.$this->input->post('username').'</a>');
				redirect('user/edit/'.$id);			
		}
		else
		{
			if($user != null)
			{
				$this->layout->set_titre('Modifier le profil de '.$user->username);
				$this->layout->view('user/edit',['errors' => $this->form_validation->error_array(), 'user' => $user]);
			}
			else
			{
				show_404();
			}
		}
	}

	public function preferences($id = NULL)
	{
		if($id == null || $this->session->rank < MODERATEUR)
		{
			$id = $this->session->id;
		}
		$user = $this->user->dataMember($id);
		
		if($this->form_validation->run())
		{
				
				$this->session->set_flashdata('success','Profil modifié avec succès.');
				$this->tracker->add('Edition du profil de <a href="'.base_url('user/show/'.$id).'">'.$this->input->post('username').'</a>');
				redirect('user/edit/'.$id);			
		}
		else
		{
			if($user != null)
			{
				$this->layout->set_titre('Modifier mes préférences');
				$this->layout->view('user/preferences',compact('user'));
			}
			else
			{
				show_404();
			}
	}
}