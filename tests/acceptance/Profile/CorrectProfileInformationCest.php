<?php
namespace Profile;

use Page\Pages\LoginPage;
use Page\Pages\ProfilePage;
use Page\Pages\RegistrationPage;
use Page\Pages\RegistrationSuccessfulPage;

/**
 * Class CorrectProfileInformationCest - test class for checking if the data from registration process
 * is saved to profile correctly
 *
 * @package Profile
 */
class CorrectProfileInformationCest
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

    public function testCorrectInformation()
    {
        $registrationPage = new RegistrationPage(true, self::$tester, '/register');
        $registrationPage->registerWith('Max', 'Test' . self::$randomInt, 'max' . self::$randomInt,
            self::$randomInt . '@gmail.com', self::$randomInt);
        $successfulRegistrationPage = new RegistrationSuccessfulPage(self::$tester);
        $successfulRegistrationPage->loginLink->click();
        $loginPage = new LoginPage(false, self::$tester);
        $loginPage->loginWith('max' . self::$randomInt, self::$randomInt);
        $profilePage = new ProfilePage(false, self::$tester);
        self::$tester->canSee('Profile info: Max Test' . self::$randomInt, $profilePage->formTitle->getLocator());
        self::$tester->assertEquals('Max', $profilePage->firstName->getValue());
        self::$tester->assertEquals('Test' . self::$randomInt, $profilePage->lastName->getValue());
        self::$tester->assertEquals('max' . self::$randomInt, $profilePage->login->getValue());
        self::$tester->assertEquals(self::$randomInt . '@gmail.com', $profilePage->email->getValue());
        $profilePage->logout();
    }

}
