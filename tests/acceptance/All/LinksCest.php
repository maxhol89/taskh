<?php
namespace All;

use Page\Pages\LoginPage;
use Page\Pages\ProfilePage;
use Page\Pages\RegistrationPage;
use Page\Pages\RegistrationSuccessfulPage;

/**
 * Class LinksCest - test class for checking if the allowed(shown) links from all pages works as expecting
 * @package All
 */
class LinksCest
{
    /**
     * @var \AcceptanceTester
     */
    private static $tester;
    private static $randomInt;

    protected function _before(\AcceptanceTester $I)
    {
        self::$tester = $I;
        self::$tester->maximizeWindow();
    }

    /**
     * @before _before
     */
    public function testRegistrationForm()
    {
        $registrationPage = new RegistrationPage(true, self::$tester, '/register');
        $registrationPage->hrefTop->click();
        self::$tester->canSeeCurrentUrlEquals('/login');
        $loginPage = new LoginPage(false, self::$tester);
        self::$tester->canSeeElement($loginPage->openRegister->getLocator());
    }

    public function testLoginFormTopLink()
    {
        $loginPage = new LoginPage(true, self::$tester);
        $loginPage->hrefTop->click();
        self::$tester->canSeeCurrentUrlEquals('/register');
        $registrationPage = new RegistrationPage(false, self::$tester, '/register');
        self::$tester->seeElement($registrationPage->email->getLocator());
    }

    public function testLoginFormLink()
    {
        $loginPage = new LoginPage(true, self::$tester);
        $loginPage->openRegister->click();
        self::$tester->canSeeCurrentUrlEquals('/register');
        $registrationPage = new RegistrationPage(false, self::$tester, '/register');
        self::$tester->canSeeElement($registrationPage->email->getLocator());
    }

    public function testSuccessfulFormLink()
    {
        $registrationPage = new RegistrationPage(true, self::$tester, '/register');
        self::$randomInt = mt_rand(0, 1000000000);
        $registrationPage->registerWith('Max', 'Test' . self::$randomInt, 'max' . self::$randomInt,
            self::$randomInt . '@gmail.com', self::$randomInt);
        $successfulPage = new RegistrationSuccessfulPage(self::$tester);
        $successfulPage->hrefTop->click();
        self::$tester->canSeeCurrentUrlEquals('/login');
        $loginPage = new LoginPage(false, self::$tester);
        self::$tester->canSeeElement($loginPage->openRegister->getLocator());
    }

    public function testSuccessfulFormTopLink()
    {
        $registrationPage = new RegistrationPage(true, self::$tester, '/register');
        self::$randomInt = mt_rand(0, 1000000000);
        $registrationPage->registerWith('Max', 'Test' . self::$randomInt, 'max' . self::$randomInt,
            self::$randomInt . '@gmail.com', self::$randomInt);
        $successfulPage = new RegistrationSuccessfulPage(self::$tester);
        $successfulPage->hrefTop->click();
        self::$tester->canSeeCurrentUrlEquals('/login');
        $loginPage = new LoginPage(false, self::$tester);
        self::$tester->canSeeElement($loginPage->openRegister->getLocator());
    }
}
