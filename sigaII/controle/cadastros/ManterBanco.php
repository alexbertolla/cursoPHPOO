<?php

/* * 
 * ***************************************************************************
 * Essa classe não está documentada, pois assim que possível, ela será substituída
 * por um webservice.
 * 
 * Perfil dos usuários que a utilizarão: Usuário SPS e Administrador do Sistema
 * 
 * Resumo: Faz o controle da classe modelo Banco e da classe de acesso
 * ao banco de dados BancoDao.
 * Controla também o relacionamento da classe Banco com outras classes.
 * 
 * Ações: 
 * 
 * Alex Bisetto Bertolla
 * alex.bertolla@embrapa.br
 * (85)3391-7163
 * Núcleo de Tecnologia da Informação
 * Embrapa Agroidústria Tropical
 * 
 * ***************************************************************************
 */

namespace controle\cadastros;

use modelo\cadastros\Banco,
    dao\cadastros\BancoDao;

class ManterBanco {

    private $banco;
    private $bancoDao;

    public function __construct() {
        $this->banco = new Banco();
        $this->bancoDao = new BancoDao();
    }

    public function __destruct() {
        unset($this->banco, $this->bancoDao);
    }

    function listar() {
        return $this->listaBdToForm($this->bancoDao->listarDao());
    }

    function listarAtivos() {
        return $this->listaBdToForm($this->bancoDao->listarAtivosDao());
    }

    function listarPorNome($nome) {
        $nome = $this->utf8Decode($nome);
        return $this->listaBdToForm($this->bancoDao->listarPorNomeDao($nome));
    }

    function listarPorNomeAtivo($nome) {
        $nome = $this->utf8Decode($nome);
        return $this->listaBdToForm($this->bancoDao->listarPorNomeAtivoDao($nome));
    }

    function buscarPorId($id) {
        $this->setBanco($this->bancoDao->buscarPorIdDao($id));
        $this->bdToForm();
        return $this->getBanco();
    }

    function buscarPorCodigo($codigo) {
        $this->setBanco($this->bancoDao->buscarPorCodigoDao($codigo));
        $this->bdToForm();
        return $this->getBanco();
    }

    function buscarPorCodigoAtivo($codigo) {
        $this->setBanco($this->bancoDao->buscarPorCodigoAtivoDao($codigo));
        $this->bdToForm();
        return $this->getBanco();
    }

    function salvar($opcao) {
        $this->formToBd();
        switch ($opcao) {
            case "inserir":
                $resultado = $this->inserir();
                break;
            case "alterar":
                $resultado = $this->alterar();
                break;
            case "excluir":
                $resultado = $this->excluir();
                break;
        }
        return $resultado;
    }

    private function inserir() {
        $id = $this->bancoDao->inserirDao($this->banco->getCodigo(), $this->banco->getNome(), $this->banco->getSituacao());
        $this->banco->setId($id);
        return $id;
    }

    private function alterar() {
        return $this->bancoDao->alterarDao($this->banco->getId(), $this->banco->getCodigo(), $this->banco->getNome(), $this->banco->getSituacao());
    }

    private function excluir() {
        return $this->bancoDao->excluirDao($this->banco->getId());
    }

    function setAtributos($atributos) {
        $this->banco->setId($atributos->id);
        $this->banco->setCodigo($atributos->codigo);
        $this->banco->setNome($atributos->nome);
        $this->banco->setSituacao(($atributos->situacao) ? 1 : 0);
    }

    function formToBd() {
        $this->decode();
    }

    function listaBdToForm($lista) {
        foreach ($lista as $banco) {
            $this->setBanco($banco);
            $this->bdToForm();
        }
        return $lista;
    }

    function bdToForm() {
        $this->encode();
    }

    private function encode() {
        $this->banco->setNome($this->utf8Encode($this->banco->getNome()));
    }

    private function decode() {
        $this->banco->setNome($this->utf8Decode($this->banco->getNome()));
    }

    private function utf8Encode($texto) {
        return utf8_encode($texto);
    }

    private function utf8Decode($texto) {
        return utf8_decode($texto);
    }

    function getBanco() {
        return $this->banco;
    }

    function setBanco($banco) {
        $this->banco = $banco;
    }

}
