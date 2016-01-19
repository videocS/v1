<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('user_model', 'user');
		$this->load->model('tracker_model', 'tracker');
	}

	public function connect()
	{
		if($this->session->rank >= MEMBRE)
		{
			$this->session->set_flashdata('error', 'Vous êtes déjà connecté.');
			redirect(base_url(''));
		}
		$this->form_validation->set_rules('username', 'nom d\'utilisateur', 'required');
		$this->form_validation->set_rules('password', 'mot de passe', 'required');			

		if($this->form_validation->run())
		{
			$user = $this->user->verif_connect($this->input->post('username'));
			if ($user && password_verify($this->input->post('password'), $user->password))
			{
				if($user->rank == BANNI)
				{
				$this->session->set_flashdata('error', 'Vous avez été banni par un administrateur.');
				redirect(base_url(''));					
				}
				else
				{
					$this->session->set_userdata([
						'id' => $user->id,
						'username' => $user->username,
						'rank' => $user->rank
					]);
					
					$this->session->set_flashdata('success', 'Bienvenue, '.$user->username.' !');
					$this->tracker->add('Connexion de '.$user->username);
					redirect(base_url(''));
				}
			}
			else
			{
				$this->layout->view('auth/connexion', ['errors' => ['Identifiants incorrects.']]);
			}

		}
		else
		{
			$this->layout->view('auth/connexion', ['errors' => $this->form_validation->error_array()]);
		}
	}

	public function register()
	{
		if($this->session->rank >= MEMBRE)
		{
			$this->session->set_flashdata('error', 'Vous êtes déjà connecté.');
			redirect(base_url(''));
		}		
		$this->form_validation->set_rules('username', 'nom d\'utilisateur', 'required|max_length[20]|is_unique[users.username]');
		$this->form_validation->set_rules('password', 'mot de passe', 'required');
		$this->form_validation->set_rules('password_confirm', 'confirmation du mot de passe', 'required|matches[password]');
		$this->form_validation->set_rules('email', 'adresse e-mail', 'required|valid_email|is_unique[users.email]');
		
		if ($this->form_validation->run())
		{
			$password = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
			$newsletter = ($this->input->post('newsletter') == 1) ? 1 : 0;
			$this->user->inscription(htmlspecialchars($this->input->post('username')), $password, htmlspecialchars($this->input->post('email')), $newsletter);
			$this->session->set_flashdata('success', 'Votre compte a bien été crée, vous pouvez maintenant vous connecter.');
			$this->tracker->add('Inscription de '.$this->input->post('username').' !');
			redirect('auth/connect');
		}
		else
		{
			$this->layout->view('auth/inscription', ['errors' => $this->form_validation->error_array()]);
		}
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url(''));
	}
}