<?php

require_once APPPATH . 'controllers/base/BaseController.php';

class batepapo extends BaseController {

    
    function salvarfoto() {     
	echo 'chegou até aqui'; die;
     move_uploaded_file($_FILES['webcam']['tmp_name'], 'uploads/webcam'.md5(time()).rand(383,1000).'.jpg'); 
       
    }
    
    


}

?>
