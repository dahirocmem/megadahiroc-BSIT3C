<?php

require_once 'StaffMember.php';

class StaffRoster {
    private $roster = [];
    private $maxSize;
    private $currentSize = 0;

    public function __construct($maxSize) {
        $this->maxSize = $maxSize;
    }

    public function addStaff($staff) {
        if ($this->currentSize < $this->maxSize) {
            $this->roster[$staff->getId()] = $staff;
            $this->currentSize++;
            return true;
        } else {
            return false;
        }
    }

    public function deleteStaff($id) {
        if (isset($this->roster[$id])) {
            unset($this->roster[$id]);
            $this->currentSize--;
            return true;
        }
        return false;
    }

    public function listStaff() {
        foreach ($this->roster as $staff) {
            echo $staff . PHP_EOL;
        }
    }

    public function countStaff() {
        return count($this->roster);
    }

    public function getStaff($id) {
        return isset($this->roster[$id]) ? $this->roster[$id] : null;
    }

    public function getRosterSize() {
        return $this->maxSize;
    }

    public function getStaffRoster() {
        return $this->roster;
    }
}
?>
