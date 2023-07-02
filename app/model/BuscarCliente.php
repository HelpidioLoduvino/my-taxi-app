<?php

class BuscarCliente {

    private $nome;
    private $localizacao;

    public function getNome() {
        return $this->nome;
    }

    public function getLocalizacao() {
        return $this->localizacao;
    }

    public function setNome($nome): void {
        $this->nome = $nome;
    }

    public function setLocalizacao($localizacao): void {
        $this->localizacao = $localizacao;
    }

}
