<?php
class Category extends CI_Controller {

	public function all($contentType = 'page') {

		$this->load->database();

		$query = $this->db->query(
			"SELECT * FROM category"
		);

		if ($contentType == 'json') {
			$this->output->set_output(json_encode($query->result_array()));
		} else {
			$data['json'] = json_encode($query->result_array());
			$this->load->helper('url');
			$this->load->view('category', $data);
		}
	}

	public function item($id, $contentType = 'page')
	{
		$this->load->database();
		$query = $this->db->query(
			"SELECT * FROM category WHERE id = ?",
			array($id)
		);
		
		if ($contentType == 'json') {
			$this->output->set_output(json_encode($query->result_array()));
		} else {
			$data['json'] = json_encode($query->result_array());
			$this->load->helper('url');
			$this->load->view('category', $data);
		}
	}

	public function subBusiness($categoryId, $contentType = 'page')
	{
		$this->load->database();
		$query = $this->db->query(
			"SELECT b.* FROM business b join category c ON b.category_id = c.id and c.id = ?",
			array($categoryId)
		);
		
		if ($contentType == 'json') {
			$this->output->set_output(json_encode($query->result_array()));
		} else {
			$data['json'] = json_encode($query->result_array());
			$this->load->helper('url');
			$this->load->view('business', $data);
		}
	}
}
?>
