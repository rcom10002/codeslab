<?php
class Business extends CI_Controller {

	public function init() {
		$this->load->helper('url');
		$pageContext = array(
			'ENTITY' => 'business',
			'ACTION' => [
				'CREATE'   => site_url('/business/create/'),
				'UPDATE'   => site_url('/business/update/'),
				'RETRIEVE' => site_url('/business/retrieve/'),
				'DELETE'   => site_url('/business/delete/')
			]
		);

		$data['pageContext'] = json_encode($pageContext);
		$this->load->helper('url');
		$this->load->view('entity', $data);
	}

	public function retrieve($contentType = 'page') {
		$this->all('json');
	}

	public function all($contentType = 'page') {

		$this->load->database();

		$query = $this->db->query(
			"SELECT * FROM business"
		);

		if ($contentType == 'json') {
			$this->output->set_output(json_encode($query->result_array()));
		} else {
			$data['json'] = json_encode($query->result_array());
			$this->load->helper('url');
			$this->load->view('entity', $data);
		}
	}

	public function item($id, $contentType = 'page')
	{
		$this->load->database();
		$query = $this->db->query(
			"SELECT * FROM business WHERE id = ?",
			array($id)
		);

		if ($contentType == 'json') {
			$this->output->set_output(json_encode($query->result_array()));
		} else {
			$data['json'] = json_encode($query->result_array());
			$this->load->helper('url');
			$this->load->view('entity', $data);
		}
	}
}
?>
