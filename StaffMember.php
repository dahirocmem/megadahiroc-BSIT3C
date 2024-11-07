<?php

require_once 'Individual.php';

class StaffMember extends Individual {
    protected $id;

    public function __construct($name, $address, $age, $companyName, $id) {
        parent::__construct($name, $address, $age, $companyName);
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }

    public function __toString() {
        return parent::__toString() . " | ID: " . $this->id;
    }
}
?>
