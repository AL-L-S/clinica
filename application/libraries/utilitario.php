<?php if (!defined('BASEPATH')) exit ('N&atilde;o &eacute; permitido acesso direto a esse script.'); 

class Utilitario {

    function autorizar($modulo, $permissoes) {
        if (array_search($modulo, $permissoes) == false)
        { return false; }
        else
        { return true; }
    }

    function preencherDireita($valor, $tamanho, $caractere="") {
        $i = strlen($valor);
        
        
        if ( $i < $tamanho){

                for ($i; $i < $tamanho; $i++) {
                    $valor .= $caractere;
                }
        }else{
            $valor = substr($valor, 0, $tamanho);}

        return $valor;
    }

    function preencherEsquerda($valor, $tamanho, $caractere="") {
        $i = strlen($valor);
        $retorno = "";
        if ($i < $tamanho){
            for ($i; $i < $tamanho; $i++) {
                $retorno .= $caractere;
            }
            $retorno .= $valor;
        }else{
            $retorno = substr($valor, 0, $tamanho);}
        
        return $retorno;
    }

    function paginacao($url, $total, $pagina, $limit=10) {

        $CI =& get_instance();

        $config['base_url']     = $url;
        $config['total_rows']   = $total;
        $config['num_links']    = 10;
        $config['per_page']     = $limit;
        $config['first_link'] 	= 'primeira';
        $config['last_link'] 	= 'última';
        $config['next_link'] 	= '&gt;';
        $config['prev_link'] 	= '&lt;';

        $CI->pagination->initialize($config);
        echo $CI->pagination->create_links();
    }

    function build_query_params($baseurl, $args=array()) {
        $parts = array();
        foreach ($args as $chave => $valor) {
        if ($chave != 'per_page') {
            array_push($parts, urlencode($chave) . '=' . urlencode($valor));
        }
        }
    return $baseurl . '?' . join('&', $parts);
    }

    function pmf_mensagem($mensagem='') {
//        var_dump($mensagem);
        if ($mensagem && strlen(trim($mensagem)) > 0) {
            echo '<div class="div-mensagem hidden" title="Mensagem:">';
            echo $mensagem;
            echo '</div>';
        }
    }
}
