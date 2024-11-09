<?php

require_once 'EmployeeRoster.php';
require_once 'PieceWorker.php';
require_once 'HourlyEmployee.php';
require_once 'CommissionEmployee.php';

class Main {
    private $employeeRoster;

    public function __construct() {
        echo "Enter the size of the employee roster: ";
        $size = trim(fgets(STDIN));
        $this->employeeRoster = new EmployeeRoster($size);
    }

    public function start() {
        do {
            // Display the current roster size
            echo "\nCurrent Roster Size: " . $this->employeeRoster->countEmployees() . " / " . $this->employeeRoster->getRosterSize() . " employees.\n";
            
            echo "\nEmployee Roster Menu\n";
            echo "1. Add Employee\n";
            echo "2. Delete Employee\n";
            echo "3. Display Employees\n";
            echo "4. Count Employees\n";
            echo "5. Payroll\n";
            echo "6. Exit\n";
            echo "Choose an option: ";

            $choice = trim(fgets(STDIN));

            switch ($choice) {
                case 1:
                    $this->addEmployee();
                    break;
                case 2:
                    $this->deleteEmployee();
                    break;
                case 3:
                    $this->displayEmployees();
                    break;
                case 4:
                    $this->countEmployees();
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

    private function addEmployee() {
        if ($this->employeeRoster->getRosterSize() <= 0) {
            echo "Roster is full. No more employees can be added.\n";
            return;
        }

        // Ask for a valid Employee ID (no auto-generation)
        echo "Enter Employee ID: ";
        $id = trim(fgets(STDIN));

        // Ensure the user provides a valid ID (not empty)
        while (empty($id)) {
            echo "Employee ID cannot be empty. Please enter a valid Employee ID: ";
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

        echo "Choose employee type:\n";
        echo "1. PieceWorker\n";
        echo "2. Hourly Employee\n";
        echo "3. Commission Employee\n";
        $type = trim(fgets(STDIN));

        switch ($type) {
            case 1:
                echo "Enter items sold: ";
                $itemsSold = trim(fgets(STDIN));

                echo "Enter wage per item: ";
                $wagePerItem = trim(fgets(STDIN));

                $employee = new PieceWorker($name, $address, $age, $companyName, $id, $itemsSold, $wagePerItem);
                break;

            case 2:
                echo "Enter hours worked: ";
                $hoursWorked = trim(fgets(STDIN));

                echo "Enter hourly rate: ";
                $hourlyRate = trim(fgets(STDIN));

                $employee = new HourlyEmployee($name, $address, $age, $companyName, $id, $hoursWorked, $hourlyRate);
                break;

            case 3:
                echo "Enter regular salary: ";
                $regularSalary = trim(fgets(STDIN));

                echo "Enter number of items sold: ";
                $itemsSold = trim(fgets(STDIN));

                echo "Enter commission rate: ";
                $commissionRate = trim(fgets(STDIN));

                $employee = new CommissionEmployee($name, $address, $age, $companyName, $id, $regularSalary, $itemsSold, $commissionRate);
                break;

            default:
                echo "Invalid input\n";
                return;
        }

        if ($this->employeeRoster->addEmployee($employee)) {
            echo "Employee added successfully!\n";
        } else {
            echo "Roster is full, can't add employee.\n";
        }
    }

    private function deleteEmployee() {
        echo "Enter Employee ID to delete: ";
        $id = trim(fgets(STDIN));

        if ($this->employeeRoster->deleteEmployee($id)) {
            echo "Employee deleted successfully!\n";
        } else {
            echo "Employee not found.\n";
        }
    }

    private function displayEmployees() {
        echo "Employee Display Options:\n";
        echo "1. Display All Employees\n";
        echo "2. Display Commission Employees\n";
        echo "3. Display Hourly Employees\n";
        echo "4. Display Piece Worker Employees\n";
        echo "Enter your choice: ";

        $choice = trim(fgets(STDIN));

        switch ($choice) {
            case 1:
                $this->employeeRoster->listEmployees();
                break;
            case 2:
                foreach ($this->employeeRoster->getEmployeeRoster() as $employee) {
                    if ($employee instanceof CommissionEmployee) {
                        echo $employee . PHP_EOL;
                    }
                }
                break;
            case 3:
                foreach ($this->employeeRoster->getEmployeeRoster() as $employee) {
                    if ($employee instanceof HourlyEmployee) {
                        echo $employee . PHP_EOL;
                    }
                }
                break;
            case 4:
                foreach ($this->employeeRoster->getEmployeeRoster() as $employee) {
                    if ($employee instanceof PieceWorker) {
                        echo $employee . PHP_EOL;
                    }
                }
                break;
            default:
                echo "Invalid choice.\n";
        }
    }

    private function countEmployees() {
        echo "Employee Count Options:\n";
        echo "1. Count All Employees\n";
        echo "2. Count Commission Employees\n";
        echo "3. Count Hourly Employees\n";
        echo "4. Count Piece Worker Employees\n";
        echo "Enter your choice: ";

        $choice = trim(fgets(STDIN));

        switch ($choice) {
            case 1:
                echo "Total Employees: " . $this->employeeRoster->countEmployees() . PHP_EOL;
                break;
            case 2:
                $count = 0;
                foreach ($this->employeeRoster->getEmployeeRoster() as $employee) {
                    if ($employee instanceof CommissionEmployee) {
                        $count++;
                    }
                }
                echo "Commission Employees: $count\n";
                break;
            case 3:
                $count = 0;
                foreach ($this->employeeRoster->getEmployeeRoster() as $employee) {
                    if ($employee instanceof HourlyEmployee) {
                        $count++;
                    }
                }
                echo "Hourly Employees: $count\n";
                break;
            case 4:
                $count = 0;
                foreach ($this->employeeRoster->getEmployeeRoster() as $employee) {
                    if ($employee instanceof PieceWorker) {
                        $count++;
                    }
                }
                echo "Piece Worker Employees: $count\n";
                break;
            default:
                echo "Invalid input.\n";
        }
    }

    private function payroll() {
        echo "Payroll Information:\n";
        foreach ($this->employeeRoster->getEmployeeRoster() as $employee) {
            echo $employee . " | Earnings: " . $employee->calculateEarnings() . PHP_EOL;
        }
    }
}

$entry = new Main();
$entry->start();
?>
