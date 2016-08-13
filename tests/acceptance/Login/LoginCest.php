<?php
namespace Login;

use Page\Pages\LoginPage;
use Page\Pages\ProfilePage;
use Page\Pages\RegistrationPage;
use Page\Pages\RegistrationSuccessfulPage;

/**
 * Class LoginCest - test class for checking sign in under same login but with different passwords
 * @package Login
 */
class LoginCest
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
        $registrationPage = new RegistrationPage(true, self::$tester, '/register');
        self::$randomInt = mt_rand(0, 1000000000);
        $registrationPage->registerWith('Max', 'Test' . self::$randomInt, 'max' . self::$randomInt,
            self::$randomInt . '@gmail.com', self::$randomInt);
    }

    /**
     * @after testLoginCorrectPassword
     * @after testLoginWrongPassword
     */
    public function test()
    {

    }

    protected function testLoginCorrectPassword()
    {
        $loginPage = new LoginPage(true, self::$tester);
        $loginPage->loginWith('max' . self::$randomInt, self::$randomInt);
        $profilePage = new ProfilePage(false, self::$tester);
        self::$tester->canSee('Max ' . 'Test' . self::$randomInt, $profilePage->formTitle->getLocator());
        self::$tester->canSeeCurrentUrlEquals('/profile');
        $profilePage->logout();
    }

    protected function testLoginWrongPassword()
    {
        $loginPage = new LoginPage(true, self::$tester);
        $loginPage->loginWithIncorrect('max' . self::$randomInt, self::$randomInt . '1');
        self::$tester->canSeeCurrentUrlEquals('/login');
    }
}
