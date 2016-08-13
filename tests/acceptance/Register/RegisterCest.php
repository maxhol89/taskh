<?php
namespace Register;

use Facebook\WebDriver\Exception\NoSuchElementException;
use Page\Pages\RegistrationPage;

/**
 * Class RegisterCest - test class for checking if there an ability to use same login for user registration,
 * and same password for one user
 *
 * @package Profile
 */
class RegisterCest
{
    /**
     * @var \AcceptanceTester
     */
    private static $tester;
    private $randomInt;

    public function _before(\AcceptanceTester $I)
    {
        self::$tester = $I;
        self::$tester->maximizeWindow();
        $this->randomInt = mt_rand(0, 1000000000);

    }

    public function testRegisterSameLogin()
    {
        $registrationPage = new RegistrationPage(true, self::$tester, '/register');
        $registrationPage->registerWith('Max', 'Test' . $this->randomInt, 'max' . $this->randomInt,
            $this->randomInt . '@gmail.com', $this->randomInt);
        try {
            $registrationPage = new RegistrationPage(true, self::$tester, '/register');
            $registrationPage->registerWith('Max', 'Test' . $this->randomInt, 'max' . $this->randomInt,
                $this->randomInt . '@gmail.com', $this->randomInt);
            self::$tester->assertTrue(false);
        } catch (NoSuchElementException $e) {
            self::$tester->assertContains('Unable to locate element: {"method":"css selector","selector":".form-content>div', $e->getMessage());
        }
    }

    public function testRegisterDifferentPasswords()
    {
        $registrationPage = new RegistrationPage(true, self::$tester, '/register');
        $registrationPage->email->fillField('testing@gmail.com');
        $registrationPage->login->fillField('login');
        $registrationPage->firstName->fillField('First');
        $registrationPage->lastName->fillField('Second');
        $registrationPage->password->fillField('1111');
        $registrationPage->repeatPassword->fillField('11111');
        $registrationPage->submitButton->click();
        self::$tester->assertEquals('The passwords doesn\'t match', $registrationPage->error->getText());
    }

    public function testRegisterShortPasswords()
    {
        $registrationPage = new RegistrationPage(true, self::$tester, '/register');
        $registrationPage->email->fillField('testing@gmail.com');
        $registrationPage->login->fillField('login');
        $registrationPage->firstName->fillField('First');
        $registrationPage->lastName->fillField('Second');
        $registrationPage->password->fillField('11');
        $registrationPage->repeatPassword->fillField('11');
        $registrationPage->submitButton->click();
        self::$tester->assertEquals('The pasword is too short (less then 3 characters)', $registrationPage->error->getText());
    }
}
