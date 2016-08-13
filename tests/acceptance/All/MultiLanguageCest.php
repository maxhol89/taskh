<?php
namespace All;

use Page\Pages\LoginPage;
use Page\Pages\ProfilePage;
use Page\Pages\RegistrationPage;
use Page\Pages\RegistrationSuccessfulPage;

/**
 * Class MultiLanguageCest - test class for checking all language buttons for all the pages
 * @package All
 */
class MultiLanguageCest
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
        $registrationPage->de->click();
        self::$tester->canSeeCurrentUrlEquals('/register?lang=de');
        self::$tester->assertNotEquals('LOGIN', $registrationPage->hrefTop->getText());
        $registrationPage->en->click();
        self::$tester->canSeeCurrentUrlEquals('/register?lang=en');
        self::$tester->assertEquals('LOGIN', $registrationPage->hrefTop->getText());
        $registrationPage->ru->click();
        self::$tester->canSeeCurrentUrlEquals('/register?lang=ru');
        self::$tester->assertNotEquals('LOGIN', $registrationPage->hrefTop->getText());
        $registrationPage->ua->click();
        self::$tester->canSeeCurrentUrlEquals('/register?lang=ua');
        self::$tester->assertNotEquals('LOGIN', $registrationPage->hrefTop->getText());
    }

    public function testLoginForm()
    {
        $loginPage = new LoginPage(true, self::$tester);
        $loginPage->de->click();
        self::$tester->canSeeCurrentUrlEquals('/login?lang=de');
        self::$tester->assertNotEquals('REGISTER', $loginPage->hrefTop->getText());
        $loginPage->en->click();
        self::$tester->canSeeCurrentUrlEquals('/login?lang=en');
        self::$tester->assertEquals('REGISTER', $loginPage->hrefTop->getText());
        $loginPage->ru->click();
        self::$tester->canSeeCurrentUrlEquals('/login?lang=ru');
        self::$tester->assertNotEquals('REGISTER', $loginPage->hrefTop->getText());
        $loginPage->ua->click();
        self::$tester->canSeeCurrentUrlEquals('/login?lang=ua');
        self::$tester->assertNotEquals('REGISTER', $loginPage->hrefTop->getText());
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
        $profilePage->de->click();
        self::$tester->canSeeCurrentUrlEquals('/profile?lang=de');
        self::$tester->assertNotEquals('LOGOUT', $profilePage->hrefTop->getText());
        $profilePage->en->click();
        self::$tester->canSeeCurrentUrlEquals('/profile?lang=en');
        self::$tester->assertEquals('LOGOUT', $profilePage->hrefTop->getText());
        $profilePage->ru->click();
        self::$tester->canSeeCurrentUrlEquals('/profile?lang=ru');
        self::$tester->assertNotEquals('LOGOUT', $profilePage->hrefTop->getText());
        $profilePage->ua->click();
        self::$tester->canSeeCurrentUrlEquals('/profile?lang=ua');
        self::$tester->assertNotEquals('LOGOUT', $profilePage->hrefTop->getText());
    }
}
