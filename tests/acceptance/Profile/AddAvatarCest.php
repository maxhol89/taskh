<?php
namespace Profile;

use Page\Pages\LoginPage;
use Page\Pages\ProfilePage;
use Page\Pages\RegistrationPage;
use Page\Pages\RegistrationSuccessfulPage;

/**
 * Class AddAvatarCest - test class for checking ability to add user photo to the profile
 * @package Profile
 */
class AddAvatarCest
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

    public function changePassword()
    {
        $registrationPage = new RegistrationPage(true, self::$tester, '/register');
        $registrationPage->registerWith('Max', 'Test' . self::$randomInt, 'max' . self::$randomInt,
            self::$randomInt . '@gmail.com', self::$randomInt);
        $successfulRegistrationPage = new RegistrationSuccessfulPage(self::$tester);
        $successfulRegistrationPage->loginLink->click();
        $loginPage = new LoginPage(false, self::$tester);
        $loginPage->loginWith('max' . self::$randomInt, self::$randomInt);
        $profilePage = new ProfilePage(false, self::$tester);
        $profilePage->attachPhoto();
    }


}
