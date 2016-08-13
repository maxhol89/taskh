<?php
namespace All;

use Page\Pages\LoginPage;
use Page\Pages\ProfilePage;
use Page\Pages\RegistrationPage;
use Page\Pages\RegistrationSuccessfulPage;

/**
 * Class TitleCest - test class for checking the form titles on all pages
 * @package All
 */
class TitleCest
{
    /**
     * @var \AcceptanceTester
     */
    private static $tester;
    private static $randomInt;

    public function _before(\AcceptanceTester $I)
    {
        self::$tester = $I;
        self::$tester->maximizeWindow();
    }

    public function testRegistrationForm()
    {
        $registrationPage = new RegistrationPage(true, self::$tester, '/register');
        $registrationPage->checkTitle('Register');
    }

    public function testLoginForm()
    {
        $loginPage = new LoginPage(true, self::$tester);
        $loginPage->checkTitle('Login');
    }

    public function testProfileForm()
    {
        $registrationPage = new RegistrationPage(true, self::$tester, '/register');
        self::$randomInt = mt_rand(0, 1000000000);
        $registrationPage->registerWith('Max', 'Test' . self::$randomInt, 'max' . self::$randomInt,
            self::$randomInt . '@gmail.com', self::$randomInt);
        $loginPage = new LoginPage(true, self::$tester);
        $loginPage->loginWith('max' . self::$randomInt, self::$randomInt);
        $profilePage = new ProfilePage(false, self::$tester);
        $profilePage->checkTitle('Profile info: ' . 'Max ' . 'Test' . self::$randomInt);
        $profilePage->logout();
    }

    public function testSuccessfulForm()
    {
        $registrationPage = new RegistrationPage(true, self::$tester, '/register');
        self::$randomInt = mt_rand(0, 1000000000);
        $registrationPage->registerWith('Max', 'Test' . self::$randomInt, 'max' . self::$randomInt,
            self::$randomInt . '@gmail.com', self::$randomInt);
        $successfulPage = new RegistrationSuccessfulPage(self::$tester);
        $successfulPage->checkTitle('Registration Successful');
    }
}
