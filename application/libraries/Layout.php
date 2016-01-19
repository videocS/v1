<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Layout
{
	private $CI;
	private $var = array();
	
/*
|===============================================================================
| Constructeur
|===============================================================================
*/
	
	public function __construct()
	{
		$this->CI =& get_instance();
		
		$this->var['output'] = '';
		
		//	Le titre est composé du nom de la méthode et du nom du contrôleur
		//	La fonction ucfirst permet d'ajouter une majuscule
		$this->var['titre'] = ($this->CI->router->fetch_method() == 'home') ? ucfirst(NAME_SITE) : ucfirst($this->CI->router->fetch_method()) . ' | ' . ucfirst(NAME_SITE);
		
		//	Nous initialisons la variable $charset avec la même valeur que
		//	la clé de configuration initialisée dans le fichier config.php
		$this->var['charset'] = $this->CI->config->item('charset');
		
		$this->var['css'] = array();
		$this->var['js'] = array();

		$this->ajouter_css(array('base', 'layout', 'reset', 'skeleton'));
	}
	
/*
|===============================================================================
| Méthodes pour charger les vues
|	. view
|	. views
|===============================================================================
*/
	
	public function view($name, $data = array())
	{
		$this->var['output'] .= $this->CI->load->view($name, $data, true);
		
		$this->CI->load->view('../views/layouts/default', $this->var);
	}
	
	public function views($name, $data = array())
	{
		$this->var['output'] .= $this->CI->load->view($name, $data, true);
		return $this;
	}

/*
|===============================================================================
| Méthodes pour modifier les variables envoyées au layout
|	. set_titre
|	. set_charset
|===============================================================================
*/
	public function set_titre($titre)
	{
		if(is_string($titre) AND !empty($titre))
		{
			$this->var['titre'] = $titre." - ".NAME_SITE;
			return true;
		}
		return false;
	}

	public function set_charset($charset)
	{
		if(is_string($charset) AND !empty($charset))
		{
			$this->var['charset'] = $charset;
			return true;
		}
		return false;
	}

	public function ajouter_css($tabnom)
	{
		foreach($tabnom as $nom){
			if(is_string($nom) AND!empty($nom) AND file_exists('./assets/css/' . $nom . '.css'))
			{
				$this->var['css'][] = base_url('assets/css/'.$nom.'.css');
			}
		}
	}
}