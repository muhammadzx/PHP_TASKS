
<?php

// ================================
// Abstract Parent Class
// ================================

abstract class BankAccount {

    public const BANK_NAME = "Jordan Bank";
    public const MIN_DEPOSIT = 10;

    public $owner;
    private $balance = 0;
    protected $accountType = "General";

    public function __construct($owner, $balance) {

        if ($balance < 0) {
            throw new InvalidArgumentException(
                "Initial balance cannot be negative"
            );
        }

        $this->owner = $owner;
        $this->balance = $balance;
    }

    public function getBalance() {
        return $this->balance;
    }

    public function deposit($amount) {

        if ($amount >= self::MIN_DEPOSIT) {
            $this->balance += $amount;
            return true;
        }

        echo "Minimum deposit is "
            . self::MIN_DEPOSIT . "<br>";

        return false;
    }

    public function withdraw($amount) {

        if ($amount > 0 && $amount <= $this->balance) {
            $this->balance -= $amount;
            return true;
        }

        echo "Invalid withdrawal amount <br>";
        return false;
    }

    protected function addToBalance($amount) {

        if ($amount < 0) {
            throw new InvalidArgumentException(
                "Amount cannot be negative"
            );
        }

        $this->balance += $amount;
    }

    public function displayBankName() {
        echo "Bank Name: " . self::BANK_NAME . "<br>";
    }

    public function displayInfo() {

        echo "Owner: $this->owner <br>";
        echo "Account Type: $this->accountType <br>";
        echo "Balance: $this->balance <br>";
    }

    // Abstract Method
    abstract public function calculateMonthlyFee();

    // Normal Method
    public function applyMonthlyFee() {

        $fee = $this->calculateMonthlyFee();

        if ($fee > 0) {
            return $this->withdraw($fee);
        }

        return true;
    }
}


// ================================
// Savings Account
// ================================

class SavingsAccount extends BankAccount {

    public const MAX_INTEREST_RATE = 10;

    public $interestRate;

    protected $accountType = "Savings";

    public function __construct($owner, $balance, $interestRate) {

        if (
            $interestRate < 0 ||
            $interestRate > self::MAX_INTEREST_RATE
        ) {
            throw new InvalidArgumentException(
                "Interest rate must be between 0 and 10"
            );
        }

        parent::__construct($owner, $balance);

        $this->interestRate = $interestRate;
    }

    public function addInterest() {

        $interest = $this->getBalance()
                  * $this->interestRate / 100;

        $this->addToBalance($interest);
    }

    public function calculateMonthlyFee() {
        return 0;
    }

    public function displayInfo() {

        parent::displayInfo();

        echo "Interest Rate: $this->interestRate% <br>";
    }
}


// ================================
// Business Account
// ================================

class BusinessAccount extends BankAccount {

    public const MONTHLY_FEE = 15;

    protected $accountType = "Business";

    public function calculateMonthlyFee() {
        return self::MONTHLY_FEE;
    }

    public function chargeFee($amount) {
        return $this->withdraw($amount);
    }

    public function chargeMonthlyFee() {
        return $this->applyMonthlyFee();
    }
}


// ================================
// Student Account
// ================================

class StudentAccount extends BankAccount {

    public const MONTHLY_FEE = 5;

    protected $accountType = "Student";

    public function calculateMonthlyFee() {
        return self::MONTHLY_FEE;
    }
}


// ================================
// Create Objects
// ================================

$accounts = [

    new SavingsAccount("Mohammad", 1000, 5),

    new BusinessAccount("Ahmad", 2000),

    new StudentAccount("Omar", 500)

];


// ================================
// Apply Monthly Fees
// ================================

foreach ($accounts as $account) {

    echo "<hr>";

    $account->displayInfo();

    echo "Monthly Fee: "
        . $account->calculateMonthlyFee()
        . "<br>";

    $account->applyMonthlyFee();

    echo "Balance After Fee: "
        . $account->getBalance()
        . "<br>";
}

?>
