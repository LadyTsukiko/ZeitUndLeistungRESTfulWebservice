<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace DB\Objects;

/**
 * Description of ErfassungsEntity
 *
 * @author Alex
 */
class ErfassungsEntity {

    public $dauer;
    private $leistung;
    private $projekt;
    private $datum;
    private $mitarbeiterid;

    public function __construct(string $mitarbeiterid, string $leistung, string $datum, string $projekt, string $dauer) {
        
        $this->mitarbeiterid = $mitarbeiterid;
        $this->datum = $datum;
        $this->projekt = $projekt;
        $this->leistung = $leistung;
        $this->dauer = $dauer;
    }
    
    public function do_something() {
        return $this->leistung.$this->projekt;
    }

}
