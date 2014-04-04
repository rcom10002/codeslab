<?php
class Test extends CI_Controller {

	public function go() {
		$this->load->database();
		$this->db->insert("status", array('NAME' => 'n1', 'DESC' => 'd1', 'PID' => 'p1'));
		var_dump($this->db->last_query());
	}
	
}
