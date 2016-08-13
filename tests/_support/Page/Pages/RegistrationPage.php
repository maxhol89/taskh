<?php
namespace Page\Pages;

use Page\Elements\Button;
use Page\Elements\Division;
use Page\Elements\Link;
use Page\Elements\TextField;

/**
 * Class RegistrationPage - class for /register page
 * @package Page\Pages
 */
class RegistrationPage extends AbstractPage
{
    private $tester;

    public $firstNameHintButton;
    public $lastNameHintButton;
    public $loginHintButton;
    public $emailHintButton;
    public $passwordHintButton;
    public $repeatPasswordHintButton;
    public $firstNameHintText;
    public $lastNameHintText;
    public $loginHintText;
    public $emailHintText;
    public $passwordHintText;
    public $repeatPasswordHintText;
    public $firstName;
    public $lastName;
    public $email;
    public $repeatPassword;

    /**
     * RegistrationPage constructor.
     * @param boolean $navigateOrNot
     * @param \AcceptanceTester $I
     * @param String $page - for creating Registration Page object use '/register'
     */
    public function __construct($navigateOrNot, $I, $page)
    {
        parent::__construct($navigateOrNot, $I, $page);

        $this->tester = $I;

        $this->firstNameHintButton = new Button ('.field-block:nth-of-type(1) .field-info>img', $this->tester);
        $this->lastNameHintButton = new Button ('.field-block:nth-of-type(2) .field-info>img', $this->tester);
        $this->loginHintButton = new Button ('.field-block:nth-of-type(3) .field-info>img', $this->tester);
        $this->emailHintButton = new Button ('.field-block:nth-of-type(4) .field-info>img', $this->tester);
        $this->passwordHintButton = new Button ('.field-block:nth-of-type(5) .field-info>img', $this->tester);
        $this->repeatPasswordHintButton = new Button ('.field-block:nth-of-type(6) .field-info>img', $this->tester);
        $this->firstNameHintText = new Division ('.field-block:nth-of-type(1) .field-info-text', $this->tester);
        $this->lastNameHintText = new Division ('.field-block:nth-of-type(2) .field-info-text', $this->tester);
        $this->loginHintText = new Division ('.field-block:nth-of-type(3) .field-info-text', $this->tester);
        $this->emailHintText = new Division ('.field-block:nth-of-type(4) .field-info-text', $this->tester);
        $this->passwordHintText = new Division ('.field-block:nth-of-type(5) .field-info-text', $this->tester);
        $this->repeatPasswordHintText = new Division ('.field-block:nth-of-type(6) .field-info-text', $this->tester);
        $this->firstName = new TextField ('input[placeholder="Enter your first name"]', $this->tester);
        $this->lastName = new TextField ('input[placeholder="Enter your last name"]', $this->tester);
        $this->email = new TextField ('input[placeholder="Enter your email"]', $this->tester);
        $this->repeatPassword = new TextField ('input[placeholder="Enter your password again"]', $this->tester);

    }

    /**
     * Method for new user registration with following parameters
     * Will pass if RegistrationSuccessfulPage is shown after form submiting
     * @param $firstName String
     * @param $lastName String
     * @param $login String
     * @param $email String
     * @param $password String
     */
    public function registerWith($firstName, $lastName, $login, $email, $password)
    {
        $this->firstName->fillField($firstName);
        $this->lastName->fillField($lastName);
        $this->login->fillField($login);
        $this->email->fillField($email);
        $this->password->fillField($password);
        $this->repeatPassword->fillField($password);
        $this->submitButton->click();
        $this->tester->waitForText('Thank you for registration.', 7, '.form-content>div');
        $successfulRegistration = new RegistrationSuccessfulPage($this->tester);
        $this->tester->canSee('Thank you for registration.', $successfulRegistration->successfulMessage->getLocator());
    }

    /**
     * Method for opening all form field hints
     * ONLY if all the hints are hidden before method execution allow to see as the result all hints
     */
    private function openAllHints()
    {
        $this->firstNameHintButton->click();
        $this->lastNameHintButton->click();
        $this->loginHintButton->click();
        $this->emailHintButton->click();
        $this->passwordHintButton->click();
        $this->repeatPasswordHintButton->click();
    }

    /**
     * Method for closing all form field hints
     * ONLY if all the hints are shown before method execution allow to hide as the result all hints
     */
    private function closeAllHints()
    {
        $this->firstNameHintButton->click();
        $this->lastNameHintButton->click();
        $this->loginHintButton->click();
        $this->emailHintButton->click();
        $this->passwordHintButton->click();
        $this->repeatPasswordHintButton->click();
    }

    /**
     * Method for checking all form field hints text
     */
    private function checkAllHintsText()
    {
        $this->tester->assertEquals('Your first name, for example: Frank',
            $this->firstNameHintText->getText());
        $this->tester->assertEquals('Your last name, for example: Willson',
            $this->lastNameHintText->getText());
        $this->tester->assertEquals('Enter your login name if you want Log In into your own profile',
            $this->loginHintText->getText());
        $this->tester->assertEquals('Your email, for example: johndoe@example.com',
            $this->emailHintText->getText());
        $this->tester->assertEquals('Password includes numbers and latin letters',
            $this->passwordHintText->getText());
        $this->tester->assertEquals('Password must be the same as first',
            $this->repeatPasswordHintText->getText());
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

}