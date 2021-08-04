<?php
     class Artigo{
        private $id;
        private $acto;
        private $iva;

        public function setId($id) { $this->id = $id; }
        public function getId() { $this->id; }

        public function setActo($acto) { $this->acto = $acto; }
        public function getActo() { $this->acto; }

        public function setIva($iva) { $this->iva = $iva; }
        public function getIva() { $this->iva; }

    }
?>
