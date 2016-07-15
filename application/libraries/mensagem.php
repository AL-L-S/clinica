<?php if (!defined('BASEPATH')) exit ('N&atilde;o &eacute; permitido acesso direto a esse script.'); 

class Mensagem {

    function getMensagem($mensagem) {
        switch ($mensagem) {
            case 'login001':
                return "Sucesso ao efetuar o login.";
                break;
            case 'login002':
                return "Usu&aacute;rio ou senha n&atilde;o validados ou usu&aacute;rio inativo.";
                break;
            case 'login003':
                return "Sucesso ao sair do sistema.";
                break;
            case 'login004':
                return "Usu&aacute;rio n&atilde;o autenticado.";
                break;
            case 'login005':
                return "Usu&aacute;rio n&atilde;o possui permiss&atilde;o de acesso a esse procedimento.";
                break;
//            case 'servidor001':
//                return "Sucesso ao gravar o servidor.";
//                break;
//            case 'servidor002':
//                return "Erro ao gravar o servidor. Opera&ccedil;&atilde;o cancelada.";
//                break;
//            case 'servidor003':
//                return "Sucesso ao excluir o servidor.";
//                break;
//            case 'servidorteto001':
//                return "Sucesso ao gravar o teto.";
//                break;
//            case 'servidorteto002':
//                return "Sucesso ao excluir o teto.";
//                break;
//             case 'servidorteto003':
//                return "Erro ao gravar o teto.";
//                break;
//            case  'servidorteto004':
//                return "Erro ao excluir o teto.";
//                break;
//            case 'suplementar001':
//                return "Sucesso ao gravar a suplementar.";
//                break;
//            case 'suplementar002':
//                return "Erro ao gravar a suplementar. Opera&ccedil;&atilde;o cancelada.";
//                break;
//            case 'suplementar003':
//                return "Sucesso ao excluir a suplementar.";
//                break;
//            case 'suplementar004':
//                return "Erro ao excluir a suplementar. Opera&ccedil;&atilde;o cancelada.";
//                break;
//            case 'pensionista001':
//                return "Sucesso ao gravar o pensionista.";
//                break;
//            case 'pensionista002':
//                return "Erro ao gravar o pensionista. Opera&ccedil;&atilde;o cancelada.";
//                break;
//            case 'pensionista003':
//                return "Excluido com sucesso!";
//                break;
//            case 'parametrogiah001':
//                return "Sucesso ao gravar o parametro da giah.";
//                break;
//            case 'parametrogiah002':
//                return "Erro ao gravar o parametro da giah. Opera&ccedil;&atilde;o cancelada.";
//                break;
//            case 'parametrogiah003':
//                return "Sucesso ao excluir o parametro da giah.";
//                break;
//            case 'parametrogiah004':
//                return "Erro ao excluir o parametro da giah. Opera&ccedil;&atilde;o cancelada.";
//                break;
//            case 'desconto001':
//                return "Sucesso ao gravar o desconto.";
//                break;
//            case 'desconto002':
//                return "Erro ao gravar o desconto. Opera&ccedil;&atilde;o cancelada.";
//                break;
//            case 'desconto003':
//                return "Sucesso ao excluir o desconto.";
//                break;
//            case 'desconto004':
//                return "Erro ao excluir o desconto. Opera&ccedil;&atilde;o cancelada.";
//                break;
//            case 'incentivo001':
//                return "Sucesso ao gravar o incentivo.";
//                break;
//            case 'incentivo002':
//                return "Erro ao gravar o incentivo. Opera&ccedil;&atilde;o cancelada.";
//                break;
//             case 'incentivo003':
//                return "Sucesso ao excluir o incentivo.";
//                break;
//            case 'incentivo004':
//                return "Erro ao excluir o incentivo. Opera&ccedil;&atilde;o cancelada.";
//                break;
//            case 'incentivo005':
//                return "N&atilde;o existem incentivos cadastrados para essa compet&ecirc;ncia.";
//                break;
//            case 'incentivo006':
//                return "Opera&ccedil;&atilde;o realizada com sucesso.";
//                break;
//            case 'incentivo007':
//                return "Esta dire&ccedil;&atilde;o n&atilde;o pode solicitar incentivo ou atingiu o limite desta dire&ccedil;&atilde;o.";
//                break;
//            case 'veiculo001':
//                return "Sucesso ao gravar o veiculo.";
//                break;
//            case 'veiculo002':
//                return "Erro ao gravar o veiculo. Opera&ccedil;&atilde;o cancelada.";
//                break;
//             case 'veiculo003':
//                return "Sucesso ao gravar o veiculo.";
//                break;
//            case 'veiculo004':
//                return "Erro ao gravar o veiculo. Opera&ccedil;&atilde;o cancelada.";
//                break;
//            case 'veiculo005':
//                return "Sucesso dar saida do veiculo.";
//                break;
//            case 'veiculo006':
//                return "Erro ao dar saida do veiculo. Opera&ccedil;&atilde;o cancelada.";
//                break;
//            case 'veiculo007':
//                return "Servidor ja possui veiculo no estacionamento.";
//                break;
//            case 'incentivoteto001':
//                return "Sucesso ao gravar o teto.";
//                break;
//            case 'incentivoteto002':
//                return "Erro ao gravar o teto. Opera&ccedil;&atilde;o cancelada.";
//                break;
//            case 'incentivoteto003':
//                return "Sucesso ao excluir o teto.";
//                break;
//            case 'incentivoteto004':
//                return "Erro ao excluir o teto.";
//                break;
//            case 'giah001':
//                return "Pontua&ccedil;&atilde;o n&atilde;o carregada.";
//                break;
//            case 'giah002':
//                return "Parametros n&atilde;o carregados.";
//                break;
//            case 'giah003':
//                return "Descontos n&atilde;o carregados.";
//                break;
//            case 'giah004':
//                return "GIAH gerada com sucesso.";
//                break;
//            case 'giah005':
//                return "Erro ao processar GIAH. Opera&ccedil;&atilde;o cancelada.";
//                break;
//            case 'provento001':
//                return "Giah n&atilde;o gerada.";
//                break;
//            case 'provento002':
//                return "Provento ja exite.";
//                break;
//            case 'provento003':
//                return "Giah ja existe.";
//                break;
//            case 'provento004':
//                return "Erro ao gerar Giah.";
//                break;
//            case 'provento005':
//                return "Provento gerado com sucesso.";
//                break;
//            case 'pontuacaomedica001':
//                return "Sucesso ao importar a pontua&ccedil;&atilde;o m&eacute;dica.";
//                break;
//            case 'pontuacaomedica002':
//                return "Erro ao importar a pontua&ccedil;&atilde;o m&eacute;dica. Opera&ccedil;&atilde;o cancelada.";
//                break;
//            case 'pontuacaomedica003':
//                return "Sucesso ao excluir a pontua&ccedil;&atilde;o m&eacute;dica.";
//                break;
//            case 'pontuacaomedica004':
//                return "Erro ao excluir a pontua&ccedil;&atilde;o m&eacute;dica. Opera&ccedil;&atilde;o cancelada.";
//                break;
//            case 'competencia001':
//                return "Compet&ecirc;ncia cadastrada com sucesso.";
//                break;
//            case 'competencia002':
//                return "Erro ao cadastrar compet&ecirc;ncia. Opera&ccedil;&atilde;o cancelada.";
//                break;
//            case 'competencia003':
//                return "Compet&ecirc;ncia fechada com sucesso.";
//                break;
//            case 'competencia004':
//                return "Erro ao fechar compet&ecirc;ncia. Opera&ccedil;&atilde;o cancelada.";
//                break;
//            case 'grupo001':
//                return "Grupo cadastrado com sucesso.";
//                break;
//            case 'grupo002':
//                return "Erro ao cadastrar grupo. Opera&ccedil;&atilde;o cancelada.";
//                break;
//            case 'agente_descricao001':
//                return "Descri&ccedil;&atilde;o do agente cadastrada com sucesso.";
//                break;
//            case 'agente_descricao002':
//                return "Erro ao cadastrar descri&ccedil;&atilde;o do agente . Opera&ccedil;&atilde;o cancelada.";
//                break;
//            case 'ceatox001':
//                return "Ficha de notifica&ccedil;&atilde;o cadastrada com sucesso.";
//                break;
//            case 'ceatox002':
//                return "Erro ao cadastrar ficha de notifica&ccedil;&atilde;o . Opera&ccedil;&atilde;o cancelada.";
//                break;
//            case 'ceatox003':
//                return "Observa&ccedil;&atilde;o gravada com sucesso.";
//                break;
//            case 'ceatox004':
//                return "Erro ao cadastrar Observa&ccedil;&atilde;o . Opera&ccedil;&atilde;o cancelada.";
//                break;
//            case 'ceatox005':
//                return "Evolu&ccedil;&atilde;o cadastrada com sucesso.";
//                break;
//            case 'ceatox006':
//                return "Erro ao cadastrar Evolu&ccedil;&atilde;o . Opera&ccedil;&atilde;o cancelada.";
//                break;
//            case 'ceatox008':
//                return "Evolu&ccedil;&atilde;o deletada com sucesso.";
//                break;
//            case 'ceatox009':
//                return "Erro ao deletar Evolu&ccedil;&atilde;o . Opera&ccedil;&atilde;o cancelada.";
//                break;
//            case 'ceatox007':
//                return "Observa&ccedil;&atilde;o deletada com sucesso.";
//                break;
//            case 'ceatox010':
//                return "Erro ao deletar Observa&ccedil;&atilde;o . Opera&ccedil;&atilde;o cancelada.";
//                break;
//            case 'emergencia001':
//                return "Ficha de notifica&ccedil;&atilde;o cadastrada com sucesso.";
//                break;
//            case 'emergencia002':
//                return "Erro ao cadastrar ficha de notifica&ccedil;&atilde;o . Opera&ccedil;&atilde;o cancelada.";
//                break;
//            case 'ambulancia001':
//                return "Entrada de ambulancia cadastrada com sucesso.";
//                break;
//            case 'ambulancia002':
//                return "Erro ao cadastrar entrada de ambulancia. Opera&ccedil;&atilde;o cancelada.";
//                break;
//            case 'ambulancia003':
//                return "Vigilante cadastrado com sucesso.";
//                break;
//            case 'ambulancia004':
//                return "Erro ao cadastrar vigilante. Opera&ccedil;&atilde;o cancelada.";
//                break;
//            case 'ambulancia005':
//                return "Vigilante deletado com sucesso.";
//                break;
//            case 'ambulancia006':
//                return "Erro ao deletar vigilante. Opera&ccedil;&atilde;o cancelada.";
//                break;
//           case 'cirurgia001':
//                return "Cirurgia atendida com sucesso.";
//                break;
//           case 'cirurgia002':
//                return "Erro ao atender a cirurgia . Opera&ccedil;&atilde;o cancelada.";
//                break;
//           case 'parecer001':
//                return "Parecer cadastrado com sucesso.";
//                break;
//           case 'parecer002':
//                return "Erro ao cadastrar parecer . Opera&ccedil;&atilde;o cancelada.";
//                break;
//           case 'parecer003':
//                return "Prioridade modificada com sucesso.";
//                break;
//           case 'parecer004':
//                return "Erro ao modificar prioridade . Opera&ccedil;&atilde;o cancelada.";
//                break;
//           case 'tomografia001':
//                return "Tomografia atendida com sucesso.";
//                break;
//           case 'tomografia002':
//                return "Erro ao atender tomografia . Opera&ccedil;&atilde;o cancelada.";
//                break;
//           case 'tomografia003':
//                return "Prioridade modificada com sucesso.";
//                break;
//           case 'tomografia004':
//                return "Erro ao modificar prioridade . Opera&ccedil;&atilde;o cancelada.";
//                break;
//           case 'vigilante001':
//                return "Vigilante excluido com sucesso.";
//                break;
//           case 'vigilante002':
//                return "Erro ao exccluir vigilante . Opera&ccedil;&atilde;o cancelada.";
//                break;
//           case 'operador001':
//                return "Operador excluido com sucesso.";
//                break;
//           case 'operador002':
//                return "Erro ao excluir operador . Opera&ccedil;&atilde;o cancelada.";
//                break;
//           case 'operador003':
//                return "Nova senha cadastrada com sucesso.";
//                break;
//           case 'operador004':
//                return "Erro ao cadastrar nova senha . Opera&ccedil;&atilde;o cancelada.";
//                break;
//           case 'operador005':
//                return "Confirma&ccedil;&atilde;o de nova senha diferente da nova senha . Opera&ccedil;&atilde;o cancelada.";
//                break;
//           case 'operador006':
//                return "Operador cadastrado com sucesso.";
//                break;
//           case 'operador007':
//                return "Erro ao cadastrar novo operador . Opera&ccedil;&atilde;o cancelada.";
//                break;
            default :
                return $mensagem;
                break;
        }

    }
	
}

/* End of file mensagem.php */
/* Location: ./application/libraries/mensagem.php */