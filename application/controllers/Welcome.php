<?php

use PhpParser\Node\Expr\Cast\Array_;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->helper('file');
		$this->load->helper('url');
		$this->load->helper('download');
		$this->load->dbutil();


	}

	public function downloadDB($current_db){
		$isAllDbBackup = true;
		$ans = $this->db->query("SHOW DATABASES")->result();

		$current_db = $this->uri->segment(2);
		print_r($current_db); die;
		
		if($isAllDbBackup){
			foreach($ans as $row){

			$currentDb = $this->db->database = $row->Database;
				$this->db->close();
				usleep(2500);
				$this->db->initialize();
				usleep(2500);

				 	if($currentDb == "mysql" || $currentDb == "information_schema" || $currentDb == "performance_schema" || $currentDb == "phpmyadmin" )
				 	{
						
					}
					
					else{

						$db_format = array('format' => 'zip','filename'=>'vt_backsam.sql');
						$backup = $this->dbutil->backup($db_format);
						$dbname =$currentDb. " isimli veritabanının ". date('d-m-Y H:i:s').'-tarihli-yedeği'.'.zip';
						 $save = 'vtler/'.$dbname;
						 write_file($save, $backup);
						 force_download($dbname,$backup);

						
						
					}

					
					// $zip = new ZipArchive();
					// $zip_name = time().".zip"; // Zip name
					// $zip->open($zip_name,  ZipArchive::CREATE);
					// foreach ($ans as $file) {
					//   echo $path = "uploadpdf/".$file;
					//   if(file_exists($path)){
					//   $zip->addFromString(basename($path),  file_get_contents($path));  
					//   }
					//   else{
					//    echo"file does not exist";
					//   }
					// }
					// $zip->close();
	

					
			
			}

		}

	}
	
	public function index()
	{
		

		error_reporting(E_ERROR | E_PARSE);

		header('Location: '); //clears POST
			


		$isPostnotEmpty = true;
		if(isset($_POST) ){
			$existingcbx = "";

			for($i = 1; $i <= count($_POST);$i++){  //[0] olarak gelen bozuk postu unset ediyorum
				if(!$_POST['checkbox('.$i.')'])
				{
					unset($_POST[0]);

				}
				else{
					
			} }

			
		
			$denemedb = "";
			foreach($_POST as $key => $pss){

				$this->db->database = trim($pss);
				
				$this->db->close();
				$this->db->initialize();
				$prefs = array(     
					'format'      => 'zip',             
					'filename'    => $pss . '.sql'
					);
				
				
				$backup =& $this->dbutil->backup($prefs); 
				
				$db_name = 'backup-on-'. date("Y-m-d-H-i-s") .'.zip';
				$save = 'uploads/'.$db_name;
				
				$this->load->helper('file');
				write_file($save, $backup); 
				$denemedb = $db_name;
				

				/*$this->load->helper('download');
				force_download($db_name, $backup);*/
		
				
				
				

				
				

				// $db_format = array('format' => 'zip','filename'=>'vt_backsam.sql');
				// 		//$backup = $this->dbutil->backup($db_format);
				// 		$dbname =$pss. " isimli veritabanının ". date('d-m-Y H:i:s').'-tarihli-yedeği'.'.zip';
				// 		 $save = 'vtler/'.$dbname;
				// 		// print_r($row->Database, $backup);
				// 		 write_file($save, $backup);
				// 		 force_download($dbname,$backup);

			}
			// $filename="uploads/";
			// header('Content-Description: File Transfer');
			// header('Content-Type: application/octet-stream');
			// header('Content-Disposition: attachment; filename="' . $denemedb . '"');
			// header('Expires: 0');
			// header('Cache-Control: must-revalidate');
			// header('Pragma: public');
			// header('Content-Length: ' . filesize($filename));
			// readfile($filename);
			// unlink($filename);
			// exit;
		
		}

		

		


		// $isAllDbBackup = true;
		// $selectedDatabase= "araba-deneme-clone";
		

		//$this->db->database = "$selectedDatabase";
		
		$view = new stdClass();
		$fixed_ans = array();
		$ans = $this->db->query("SHOW DATABASES")->result();
		foreach($ans as $row){
			if($row->Database == "mysql" || $row->Database == "information_schema" || $row->Database == "performance_schema" || $row->Database == "phpmyadmin" ){
				$fixed_ans = $row->Database;
			}
		}
		$view->all_databases = $ans;
		

		// $this->db->close();
		// 			$this->db->initialize();

		

		
			foreach($ans as $row){

			$currentDb = $this->db->database = $row->Database;
				$this->db->close();
				usleep(2500);
				$this->db->initialize();
				usleep(2500);

				 	if($currentDb == "mysql" || $currentDb == "information_schema" || $currentDb == "performance_schema" || $currentDb == "phpmyadmin" )
				 	{
						
					}
					
					else{


						$db_format = array('format' => 'zip','filename'=>'vt_backsam.sql');
						$backup = $this->dbutil->backup($db_format);
						$dbname =$currentDb. " isimli veritabanının ". date('d-m-Y H:i:s').'-tarihli-yedeği'.'.zip';
						 $save = 'vtler/'.$dbname;
						 write_file($save, $backup);
						 //force_download($dbname,$backup);

						
						
					}

					
					// $zip = new ZipArchive();
					// $zip_name = time().".zip"; // Zip name
					// $zip->open($zip_name,  ZipArchive::CREATE);
					// foreach ($ans as $file) {
					//   echo $path = "uploadpdf/".$file;
					//   if(file_exists($path)){
					//   $zip->addFromString(basename($path),  file_get_contents($path));  
					//   }
					//   else{
					//    echo"file does not exist";
					//   }
					// }
					// $zip->close();
	

					
			
			}

		//	force_download();
		

		$this->load->view("home", $view);

		

	}
}
