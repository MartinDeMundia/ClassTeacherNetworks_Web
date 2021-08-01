<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 *  @author   : Creativeitem
 *  date    : 14 september, 2017
 *  Ekattor School Management System Pro
 *  http://codecanyon.net/user/Creativeitem
 *  http://support.creativeitem.com
 */
class Home extends CI_Controller {

  protected $theme;

  // constructor
  function __construct()
  {
    parent::__construct();
    $this->load->database();
    $this->load->library('session');    
  }

  // default function
  public function index() {
    $page_data['page_name']  = 'home';
    $page_data['page_title'] = get_phrase('home');
    //$this->load->view('frontend/'.$this->theme.'/index', $page_data);
	$this->load->view('backend/login');
  }
   
}
