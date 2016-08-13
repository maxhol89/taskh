<?php
namespace All;

use Page\Pages\LoginPage;
use Page\Pages\ProfilePage;
use Page\Pages\RegistrationPage;

/**
 * Class HintsCest - test class which check all hints on all pages
 * @package All
 */
class HintsCest
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
        self::$randomInt = mt_rand(0, 1000000000);
    }

    /**
     * @before _before
     */
    public function testRegistrationForm()
    {
        $registrationPage = new RegistrationPage(true, self::$tester, '/register');
        $registrationPage->makeSureHintsWorkFine();
    }

    public function testLoginForm()
    {
        $loginPage = new LoginPage(true, self::$tester);
        $loginPage->makeSureHintsWorkFine();
    }

    public function testProfileForm()
    {
        $registrationPage = new RegistrationPage(true, self::$tester, '/register');
        $registrationPage->registerWith('Max', 'Test' . self::$randomInt, 'max' . self::$randomInt,
            self::$randomInt . '@gmail.com', self::$randomInt);
        $loginPage = new LoginPage(true, self::$tester);
        $loginPage->loginWith('max' . self::$randomInt, self::$randomInt);
        $profilePage = new ProfilePage(false, self::$tester);
        $profilePage->makeSureHintsWorkFine();
        $profilePage->logout();
    }
}
