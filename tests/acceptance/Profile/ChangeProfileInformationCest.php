<?php
namespace Profile;

use Page\Pages\AbstractPage;
use Page\Pages\LoginPage;
use Page\Pages\ProfilePage;
use Page\Pages\RegistrationPage;
use Page\Pages\RegistrationSuccessfulPage;

/**
 * Class ChangeProfileInformationCest - test class for checking ability to change and save valid and invalid values
 * for profile updating
 *
 * @package Profile
 */
class ChangeProfileInformationCest
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
        $registrationPage = new RegistrationPage(true, self::$tester, '/register');
        $registrationPage->registerWith('Max', 'Test' . self::$randomInt, 'max' . self::$randomInt,
            self::$randomInt . '@gmail.com', self::$randomInt);
        $successfulRegistrationPage = new RegistrationSuccessfulPage(self::$tester);
        $successfulRegistrationPage->loginLink->click();
        $loginPage = new LoginPage(false, self::$tester);
        $loginPage->loginWith('max' . self::$randomInt, self::$randomInt);
    }

    public function changePassword()
    {
        $profilePage = new ProfilePage(false, self::$tester);
        $profilePage->changePasswordTo(self::$randomInt . self::$randomInt);
        $profilePage->logout();
        $loginPage2 = new LoginPage(false, self::$tester);
        $loginPage2->loginWith('max' . self::$randomInt, self::$randomInt . self::$randomInt);
        $profilePage2 = new ProfilePage(false, self::$tester);
        self::$tester->canSee('Profile info: Max Test' . self::$randomInt, $profilePage2->formTitle->getLocator());
        self::$tester->assertEquals('Max', $profilePage2->firstName->getValue());
        self::$tester->assertEquals('Test' . self::$randomInt, $profilePage2->lastName->getValue());
        self::$tester->assertEquals('max' . self::$randomInt, $profilePage2->login->getValue());
        self::$tester->assertEquals(self::$randomInt . '@gmail.com', $profilePage2->email->getValue());
        $profilePage2->logout();
    }

    public function changeToDifferentPasswords()
    {
        $profilePage = new ProfilePage(false, self::$tester);
        $profilePage->password->fillField('1111');
        $profilePage->repeatPassword->fillField('11111');
        $profilePage->submitButton->click();
        self::$tester->assertEquals('The passwords doesn\'t match', $profilePage->error->getText());
        $profilePage->logout();
    }

    public function changeAllOtherFields()
    {
        $profilePage = new ProfilePage(false, self::$tester);
        $profilePage->firstName->fillField('Maksym');
        $profilePage->lastName->fillField(self::$randomInt . 'Test');
        $profilePage->login->fillField('max' . self::$randomInt . self::$randomInt);
        $profilePage->email->fillField(self::$randomInt . self::$randomInt . '@gmail.com');
        $profilePage->submitButton->click();
        $profilePage->logout();
        $loginPage2 = new LoginPage(false, self::$tester);
        $loginPage2->loginWith('max' . self::$randomInt . self::$randomInt, self::$randomInt);
        $profilePage2 = new ProfilePage(false, self::$tester);
        self::$tester->canSee('Profile info: Maksym ' . self::$randomInt . 'Test', $profilePage2->formTitle->getLocator());
        self::$tester->assertEquals('Maksym', $profilePage2->firstName->getValue());
        self::$tester->assertEquals(self::$randomInt . 'Test', $profilePage2->lastName->getValue());
        self::$tester->assertEquals('max' . self::$randomInt . self::$randomInt, $profilePage2->login->getValue());
        self::$tester->assertEquals(self::$randomInt . self::$randomInt . '@gmail.com', $profilePage2->email->getValue());
        $profilePage2->logout();
    }

    public function changeAllToMoreThanAllowedLength()
    {
        $profilePage = new ProfilePage(false, self::$tester);
        $profilePage->firstName->fillField('aaaaaaaaaaaaaaaaaaaaaaaaaaaaaab');
        $profilePage->lastName->fillField('aaaaaaaaaaaaaaaaaaaaaaaaaaaaaab');
        $profilePage->login->fillField('aaaaaaaaaaaaaaaaaaaaaaaaaaaaaab');
        $profilePage->email->fillField('aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa@mail.com');
        $profilePage->changePasswordTo('aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaab');
        $profilePage->error->isVisible() ? $k = 0 : $k = 1;
        $profilePage->logout();
        $loginPage2 = new LoginPage(false, self::$tester);
        $loginPage2->loginWith('aaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa');
        $profilePage2 = new ProfilePage(false, self::$tester);
        switch ($k) {
            case 0:
                self::$tester->cantSee('Profile info: aaaaaaaaaaaaaaaaaaaaaaaaaaaaaa aaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', $profilePage2->formTitle->getLocator());
                break;
            case 1:
                self::$tester->canSee('Profile info: aaaaaaaaaaaaaaaaaaaaaaaaaaaaaa aaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', $profilePage2->formTitle->getLocator());
                break;
        }
        $profilePage2->logout();
    }

    public function changeAllToBlank()
    {
        $profilePage = new ProfilePage(false, self::$tester);
        $profilePage->firstName->fillField('');
        $profilePage->lastName->fillField('');
        $profilePage->login->fillField('');
        $profilePage->email->fillField('');
        $profilePage->changePasswordTo('');
        $profilePage->error->isVisible() ? $k = 0 : $k = 1;
        $profilePage->logout();
        $loginPage2 = new LoginPage(false, self::$tester);
        $loginPage2->loginWith('max' . self::$randomInt, self::$randomInt);
        $profilePage2 = new ProfilePage(false, self::$tester);
        switch ($k) {
            case 0:
                self::$tester->cantSee('Max Test' . self::$randomInt, $profilePage2->formTitle->getLocator());
                break;
            case 1:
                self::$tester->canSee('Max Test' . self::$randomInt, $profilePage2->formTitle->getLocator());
                break;
        }
        $profilePage2->logout();
    }

    public function changeToInvalidMail()
    {
        $mail = AbstractPage::returnInvalidMail();
        $profilePage = new ProfilePage(false, self::$tester);
        $profilePage->email->fillField($mail);
        $profilePage->submitButton->click();
        $profilePage->error->isVisible() ? $k = 0 : $k = 1;
        $profilePage->logout();
        $loginPage2 = new LoginPage(false, self::$tester);
        $loginPage2->loginWith('max' . self::$randomInt, self::$randomInt);
        $profilePage2 = new ProfilePage(false, self::$tester);
        switch ($k) {
            case 0:
                self::$tester->cantSee($mail, $profilePage2->email->getLocator());
                break;
            case 1:
                self::$tester->canSee($mail, $profilePage2->email->getLocator());
                break;
        }
        $profilePage2->logout();
    }

    public function changeToValidMail()
    {
        $mail = AbstractPage::returnValidMail(10);
        $profilePage = new ProfilePage(false, self::$tester);
        $profilePage->email->fillField($mail);
        $profilePage->submitButton->click();
        $profilePage->error->isVisible() ? $k = 0 : $k = 1;
        $profilePage->logout();
        $loginPage2 = new LoginPage(false, self::$tester);
        $loginPage2->loginWith('max' . self::$randomInt, self::$randomInt);
        $profilePage2 = new ProfilePage(false, self::$tester);
        switch ($k) {
            case 0:
                self::$tester->cantSee($mail, $profilePage2->email->getLocator());
                break;
            case 1:
                self::$tester->canSee($mail, $profilePage2->email->getLocator());
                break;
        }
        $profilePage2->logout();
    }

    public function changeToValidPassword()
    {
        $password = AbstractPage::returnValidPassword(10);
        $profilePage = new ProfilePage(false, self::$tester);
        $profilePage->changePasswordTo($password);
        $profilePage->error->isVisible() ? $k = 0 : $k = 1;
        $profilePage->logout();
        $loginPage2 = new LoginPage(false, self::$tester);
        $loginPage2->loginWith('max' . self::$randomInt, $password);
        $profilePage2 = new ProfilePage(false, self::$tester);
        switch ($k) {
            case 0:
                self::$tester->cantSee('Profile', $profilePage2->formTitle->getLocator());
                break;
            case 1:
                self::$tester->canSee('Profile', $profilePage2->formTitle->getLocator());
                break;
        }
        $profilePage2->logout();
    }

    public function changeToInvalidPassword()
    {
        $password = AbstractPage::returnInvalidPassword(10);
        $profilePage = new ProfilePage(false, self::$tester);
        $profilePage->changePasswordTo($password);
        $profilePage->error->isVisible() ? $k = 0 : $k = 1;
        $profilePage->logout();
        $loginPage2 = new LoginPage(false, self::$tester);
        $loginPage2->loginWith('max' . self::$randomInt, self::$randomInt);
        $profilePage2 = new ProfilePage(false, self::$tester);
        switch ($k) {
            case 0:
                self::$tester->cantSee('Profile', $profilePage2->formTitle->getLocator());
                break;
            case 1:
                self::$tester->canSee('Profile', $profilePage2->formTitle->getLocator());
                break;
        }
        $profilePage2->logout();
    }

    public function changeToValidLogin()
    {
        $login = AbstractPage::returnValidLogin(10);
        $profilePage = new ProfilePage(false, self::$tester);
        $profilePage->login->fillField($login);
        $profilePage->submitButton->click();
        $profilePage->error->isVisible() ? $k = 0 : $k = 1;
        $profilePage->logout();
        $loginPage2 = new LoginPage(false, self::$tester);
        $loginPage2->loginWith($login, self::$randomInt);
        $profilePage2 = new ProfilePage(false, self::$tester);
        switch ($k) {
            case 0:
                self::$tester->cantSee($login, $profilePage2->login->getLocator());
                break;
            case 1:
                self::$tester->canSee($login, $profilePage2->login->getLocator());
                break;
        }
        $profilePage2->logout();
    }

    public function changeToInvalidLogin()
    {
        $login = AbstractPage::returnInvalidLogin(10);
        $profilePage = new ProfilePage(false, self::$tester);
        $profilePage->login->fillField($login);
        $profilePage->submitButton->click();
        $profilePage->error->isVisible() ? $k = 0 : $k = 1;
        $profilePage->logout();
        $loginPage2 = new LoginPage(false, self::$tester);
        $loginPage2->loginWith('max' . self::$randomInt, self::$randomInt);
        $profilePage2 = new ProfilePage(false, self::$tester);
        switch ($k) {
            case 0:
                self::$tester->cantSee($login, $profilePage2->login->getLocator());
                break;
            case 1:
                self::$tester->canSee($login, $profilePage2->login->getLocator());
                break;
        }
        $profilePage2->logout();
    }

}
