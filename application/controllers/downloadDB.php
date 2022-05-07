<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class downloadDB extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->helper('file');
		$this->load->helper('url','uri');
		$this->load->helper('download');
		$this->load->dbutil();
        

    }

    public function index(){
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
						//  print_r(" bunlardan biri- " . $currentDb);
						//  echo "<br>";
					}
					
					else{

						
						// print_r(" bunlardan degil " . $currentDb);
						// echo "<br>";

						$db_format = array('format' => 'zip','filename'=>'vt_backsam.sql');
						$backup = $this->dbutil->backup($db_format);
						$dbname =$currentDb. " isimli veritabanının ". date('d-m-Y H:i:s').'-tarihli-yedeği'.'.zip';
						 $save = 'vtler/'.$dbname;
						// print_r($row->Database, $backup);
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

		//	force_download();

		}
        $this->load->view("welcome_message.php");

    }

}



    ?>