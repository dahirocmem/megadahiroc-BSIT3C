<?php

require_once 'StaffRoster.php';
require_once 'ItemBasedWorker.php';
require_once 'HourlyStaff.php';
require_once 'CommissionBasedStaff.php';

class Main {
    private $staffRoster;

    public function __construct() {
        echo "Enter the size of the staff roster: ";
        $size = trim(fgets(STDIN));
        $this->staffRoster = new StaffRoster($size);
    }

    public function start() {
        do {
            echo "\nCurrent Roster Size: " . $this->staffRoster->countStaff() . " / " . $this->staffRoster->getRosterSize() . " staff members.\n";
            
            echo "\nStaff Roster Menu\n";
            echo "1. Add Staff\n";
            echo "2. Delete Staff\n";
            echo "3. Display Staff\n";
            echo "4. Count Staff\n";
            echo "5. Payroll\n";
            echo "6. Exit\n";
            echo "Choose an option: ";

            $choice = trim(fgets(STDIN));

            switch ($choice) {
                case 1:
                    $this->addStaff();
                    break;
                case 2:
                    $this->deleteStaff();
                    break;
                case 3:
                    $this->displayStaff();
                    break;
                case 4:
                    $this->countStaff();
                    break;
                case 5:
                    $this->payroll();
                    break;
                case 6:
                    echo "Exiting...\n";
                    break;
                default:
                    echo "Invalid input. Please try again.\n";
            }
        } while ($choice != 6);
    }

    private function addStaff() {
        if ($this->staffRoster->getRosterSize() <= 0) {
            echo "Roster is full. No more staff can be added.\n";
            return;
        }

        echo "Enter Staff ID: ";
        $id = trim(fgets(STDIN));

        while (empty($id)) {
            echo "Staff ID cannot be empty. Please enter a valid Staff ID: ";
            $id = trim(fgets(STDIN));
        }

        echo "Enter Name: ";
        $name = trim(fgets(STDIN));

        echo "Enter Address: ";
        $address = trim(fgets(STDIN));

        echo "Enter Age: ";
        $age = trim(fgets(STDIN));

        echo "Enter Company Name: ";
        $companyName = trim(fgets(STDIN));

        echo "Choose staff type:\n";
        echo "1. Item-Based Worker\n";
        echo "2. Hourly Staff\n";
        echo "3. Commission-Based Staff\n";
        $type = trim(fgets(STDIN));

        switch ($type) {
            case 1:
                echo "Enter items sold: ";
                $itemsSold = trim(fgets(STDIN));

                echo "Enter wage per item: ";
                $wagePerItem = trim(fgets(STDIN));

                $staff = new ItemBasedWorker($name, $address, $age, $companyName, $id, $itemsSold, $wagePerItem);
                break;

            case 2:
                echo "Enter hours worked: ";
                $hoursWorked = trim(fgets(STDIN));

                echo "Enter hourly rate: ";
                $hourlyRate = trim(fgets(STDIN));

                $staff = new HourlyStaff($name, $address, $age, $companyName, $id, $hoursWorked, $hourlyRate);
                break;

            case 3:
                echo "Enter regular salary: ";
                $regularSalary = trim(fgets(STDIN));

                echo "Enter number of items sold: ";
                $itemsSold = trim(fgets(STDIN));

                echo "Enter commission rate: ";
                $commissionRate = trim(fgets(STDIN));

                $staff = new CommissionBasedStaff($name, $address, $age, $companyName, $id, $regularSalary, $itemsSold, $commissionRate);
                break;

            default:
                echo "Invalid input\n";
                return;
        }

        if ($this->staffRoster->addStaff($staff)) {
            echo "Staff member added successfully!\n";
        } else {
            echo "Roster is full, can't add staff.\n";
        }
    }

    private function deleteStaff() {
        echo "Enter Staff ID to delete: ";
        $id = trim(fgets(STDIN));

        if ($this->staffRoster->deleteStaff($id)) {
            echo "Staff member deleted successfully!\n";
        } else {
            echo "Staff member not found.\n";
        }
    }

    private function displayStaff() {
        echo "Staff Display Options:\n";
        echo "1. Display All Staff\n";
        echo "2. Display Commission-Based Staff\n";
        echo "3. Display Hourly Staff\n";
        echo "4. Display Item-Based Workers\n";
        echo "Enter your choice: ";

        $choice = trim(fgets(STDIN));

        switch ($choice) {
            case 1:
                $this->staffRoster->listStaff();
                break;
            case 2:
                foreach ($this->staffRoster->getStaffRoster() as $staff) {
                    if ($staff instanceof CommissionBasedStaff) {
                        echo $staff . PHP_EOL;
                    }
                }
                break;
            case 3:
                foreach ($this->staffRoster->getStaffRoster() as $staff) {
                    if ($staff instanceof HourlyStaff) {
                        echo $staff . PHP_EOL;
                    }
                }
                break;
            case 4:
                foreach ($this->staffRoster->getStaffRoster() as $staff) {
                    if ($staff instanceof ItemBasedWorker) {
                        echo $staff . PHP_EOL;
                    }
                }
                break;
            default:
                echo "Invalid choice.\n";
        }
    }

    private function countStaff() {
        echo "Staff Count Options:\n";
        echo "1. Count All Staff\n";
        echo "2. Count Commission-Based Staff\n";
        echo "3. Count Hourly Staff\n";
        echo "4. Count Item-Based Workers\n";
        echo "Enter your choice: ";

        $choice = trim(fgets(STDIN));

        switch ($choice) {
            case 1:
                echo "Total Staff: " . $this->staffRoster->countStaff() . PHP_EOL;
                break;
            case 2:
                $count = 0;
                foreach ($this->staffRoster->getStaffRoster() as $staff) {
                    if ($staff instanceof CommissionBasedStaff) {
                        $count++;
                    }
                }
                echo "Commission-Based Staff: $count\n";
                break;
            case 3:
                $count = 0;
                foreach ($this->staffRoster->getStaffRoster() as $staff) {
                    if ($staff instanceof HourlyStaff) {
                        $count++;
                    }
                }
                echo "Hourly Staff: $count\n";
                break;
            case 4:
                $count = 0;
                foreach ($this->staffRoster->getStaffRoster() as $staff) {
                    if ($staff instanceof ItemBasedWorker) {
                        $count++;
                    }
                }
                echo "Item-Based Workers: $count\n";
                break;
            default:
                echo "Invalid input.\n";
        }
    }

    private function payroll() {
        echo "Payroll Information:\n";
        foreach ($this->staffRoster->getStaffRoster() as $staff) {
            echo $staff . " | Earnings: " . $staff->calculateEarnings() . PHP_EOL;
        }
    }
}

$entry = new Main();
$entry->start();
?>
