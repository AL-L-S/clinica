<?php

require_once APPPATH . 'controllers/base/BaseController.php';

class salvarfoto extends BaseController {

    
    function salvarfoto() {   
//        echo 'chegou aqui'; die;
  $bunda =  base_url();
echo var_dump($bunda); die;
//	echo 'chegou até aqui caçanmba'; die;
     move_uploaded_file($_FILES['webcam']['tmp_name'], $bunda. " upload/webcam/".md5(time()).rand(383,1000).'.jpg'); 
       
    }
    
    


}

?>
