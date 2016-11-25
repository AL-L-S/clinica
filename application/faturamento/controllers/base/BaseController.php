
<?php

class BaseController extends Controller {

    function  __construct() {
        parent::Controller();
    }
    
    function loadView($view, $data=null) {
        $this->load->view('header');
        $data ? $this->load->view($view, $data) : $this->load->view($view);
        $this->load->view('footer');
    }

}
?>
