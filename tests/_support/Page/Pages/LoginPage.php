<?php
namespace Page\Pages;

use Page\Elements\Button;
use Page\Elements\Division;
use Page\Elements\Link;
use Page\Elements\TextField;

/**
 * Class LoginPage - class for /login page
 * @package Page\Pages
 */
class LoginPage extends AbstractPage
{
    private $tester;

    public $openRegister;
    public $loginHintButton;
    public $passwordHintButton;
    public $loginHintText;
    public $passwordHintText;

    /**
     * LoginPage constructor.
     * @param boolean $navigateOrNot
     * @param \AcceptanceTester $I
     */
    public function __construct($navigateOrNot, $I)
    {
        parent::__construct($navigateOrNot, $I, '/login');

        $this->tester = $I;

        $this->openRegister = new Link ('.register_href', $this->tester);
        $this->loginHintButton = new Button ('.field-block:nth-of-type(1) .field-info>img', $this->tester);
        $this->passwordHintButton = new Button ('.field-block:nth-of-type(2) .field-info>img', $this->tester);
        $this->loginHintText = new Division ('.field-block:nth-of-type(1) .field-info-text', $this->tester);
        $this->passwordHintText = new Division ('.field-block:nth-of-type(2) .field-info-text', $this->tester);

    }

    /**
     * Method for opening all form field hints
     * ONLY if all the hints are hidden before method execution allow to see as the result all hints
     */
    private function openAllHints()
    {
        $this->loginHintButton->click();
        $this->passwordHintButton->click();
    }

    /**
     * Method for closing all form field hints
     * ONLY if all the hints are shown before method execution allow to hide as the result all hints
     */
    private function closeAllHints()
    {
        $this->loginHintButton->click();
        $this->passwordHintButton->click();
    }

    /**
     * Method for checking all form field hints text
     */
    private function checkAllHintsText()
    {
        $this->tester->assertEquals('Enter your login name if you want Log In into your own profile',
            $this->loginHintText->getText());
        $this->tester->assertEquals('Password includes numbers and latin letters',
            $this->passwordHintText->getText());
    }

    /**
     * Method for testing hints: if they are opened, closed properly and text is correct on each of them
     */
    public function makeSureHintsWorkFine()
    {
        $this->openAllHints();
        $this->checkAllHintsText();
        $this->closeAllHints();
    }

    /**
     * Method for sign in to user profile with following credentials
     * @param $login String
     * @param $password String
     */
    public function loginWith($login, $password)
    {
        $this->login->fillField($login);
        $this->password->fillField($password);
        $this->submitButton->click();
        $this->tester->waitForElementVisible('input[name="user_photo"]', 15);
        $profilePage = new ProfilePage(false, $this->tester);
        $this->tester->canSeeCurrentUrlEquals('/profile');
        $this->tester->canSee('Profile info', $profilePage->formTitle->getLocator());
    }

    /**
     * Method for submitting sign in form with following credentials
     * @param $login String
     * @param $password String
     */
    public function loginWithIncorrect($login, $password)
    {
        $this->login->fillField($login);
        $this->password->fillField($password);
        $this->submitButton->click();
    }

}