<?php

require_once 'StaffMember.php';

class ItemBasedWorker extends StaffMember {
    private $itemsSold;
    private $wagePerItem;

    public function __construct($name, $address, $age, $companyName, $id, $itemsSold, $wagePerItem) {
        parent::__construct($name, $address, $age, $companyName, $id);
        $this->itemsSold = $itemsSold;
        $this->wagePerItem = $wagePerItem;
    }

    public function calculateEarnings() {
        return $this->itemsSold * $this->wagePerItem;
    }

    public function __toString() {
        return "ItemBasedWorker ID: {$this->getId()} - Name: {$this->getName()} - Earnings: {$this->calculateEarnings()}";
    }
}
?>
