<?php
/*
 * 1. USERNAME is unique
 * 2. before user account is activated, password is combination of USERNAME and PASSWORD, and encrypted with md5
 * 3. after user account is activated, the encrypted password is encrypted again with md5
 * 4. USERNAME and PASSWORD can only be changed when the account is activated, otherwise the user has to request to reset his account
 * 5. whenever PASSWORD or USERNAME is changed, it's required to encrypt password again with the rules described in step 2 and 3
 * 6. currently user can only send a request for account reset to system administration, self-service with registered mail is not available
 */
class User extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // session could be used to retrieve language which user chose
        // default language setting can be found at ./application/config/config.php
        $this->lang->load("phrase","english");
        $this->load->helper('language');
        
    }

	public function all($contentType = 'page') {

		$this->load->database();

		$query = $this->db->query(
			"SELECT * FROM user"
		);

		if ($contentType == 'json') {
			$this->output->set_output(json_encode($query->result_array()));
		} else {
			$data['json'] = json_encode($query->result_array());
			$this->load->helper('url');
			$this->load->view('entity', $data);
		}
	}

	public function item($id, $contentType = 'page') {

		$this->load->database();

		$query = $this->db->query(
			"SELECT * FROM user WHERE id = ?",
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

	public function register() {
		
		// initialization begin
		if($this->input->post() === FALSE) {
			$this->load->helper('url');
			$this->load->view('user_registration');
			return;
		}
		// initialization end

		// data check before register begin

		$this->load->database();

		$postValues = $this->input->post();
		$errors = array();
		if (!$postValues['USERNAME']) {
			$errors[] = $this->lang->line('error_field_username_missing');
		}
		if ($this->db->query("SELECT * FROM user WHERE USERNAME = ?", array($postValues['USERNAME']))->num_rows > 0) {
			$errors[] = $this->lang->line('error_field_username_occupied');
		}
		if (!$postValues['EMAIL']) {
			$errors[] = $this->lang->line('error_field_email_missing');
		}
		if (!$postValues['PASSWORD']) {
			$errors[] = $this->lang->line('error_field_password_missing');
		}
		if (!($postValues['PASSWORD_CONFIRM'] == $postValues['PASSWORD'])) {
			$errors[] = $this->lang->line('error_field_password_not_match');
		}
		if (count($errors) > 0) {
			$this->output->set_output(json_encode(array('errors' => $errors)));
			return;
		}
		// data check before register end

		$encryptString = md5($postValues['USERNAME'].$postValues['PASSWORD']);
		$query = $this->db->query(
			"INSERT INTO user (FIRST_NAME, LAST_NAME, EMAIL, PHONE, USERNAME, PASSWORD, TYPE, STATUS_ID) VALUES (?, ?, ?, ?, ?, ?, ?, ?)",
			array(
			      $postValues['FIRST_NAME'], $postValues['LAST_NAME'], $postValues['EMAIL'], $postValues['PHONE'],
			      $postValues['USERNAME'], $encryptString, $postValues['TYPE'], $postValues['STATUS_ID']
			      )
		);

		$this->load->helper('url');
        $this->load->library('email');
        $this->email->initialize();
        $this->email->from('rcom10002@163.com', 'rcom10002');  
        $this->email->to($postValues['EMAIL']);
        $this->email->subject('ci-demo: activate your account');
        $emailContent = $this->lang->line('mail_template_user_activation');
        $emailContent = str_replace('{{USERNAME}}', $postValues['USERNAME'], $emailContent);
        $emailContent = str_replace('{{URL}}', site_url("/user/activate/$encryptString"), $emailContent);
        $this->email->message($emailContent);
        //$this->email->attach('application\controllers\1.jpeg');
        $this->email->send();  

		$this->output->set_output(json_encode(array('message' => "Congratulation! Registration is completed successfully!")));
	}

	public function activate($token)
	{
		$this->load->database();
		$this->db->query("UPDATE user SET PASSWORD = ? WHERE PASSWORD = ?", array(md5($token), $token));
		if ($this->db->affected_rows() > 0) {
			$this->output->set_output(json_encode(array('message' => 'You have your account activated!')));
		} else {
			$this->output->set_output(json_encode(array('message' => 'You are failed to have your account activated! Please ask system administrator for help!')));
		}
	}

	public function signon()
	{
		$postValues = $this->input->post();
		if ($postValues === FALSE) {
			$this->load->helper('url');
			$this->load->view('user_signon');
			return;
		}

		$this->load->database();
		$credentialParams = array($postValues['USERNAME'], $postValues['PASSWORD']);
		if ($this->db->query("SELECT * FROM user WHERE md5(md5(CONCAT(?, ?))) = PASSWORD", $credentialParams)->num_rows > 0) {
			$this->load->library('session');
			$this->session->set_userdata('PROFILE', array('IS_SIGNON' => true));
			$this->output->set_output(json_encode(array('message' => "Congratulation! You successfully signed on!")));
		} else {
			$this->output->set_output(json_encode(array('error' => "Oops! Your username or password might be incorrect!")));
		}
	}
}
?>
