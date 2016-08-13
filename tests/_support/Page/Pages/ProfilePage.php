<?php
namespace Page\Pages;

use Page\Elements\Button;
use Page\Elements\Division;
use Page\Elements\Link;

/**
 * Class ProfilePage - class for /profile page
 * @package Page\Pages
 */
class ProfilePage extends RegistrationPage
{
    private $tester;

    public $addPhotoLocator;
    public $photoLocator;

    /**
     * RegistrationPage constructor.
     * @param boolean $navigateOrNot
     * @param \AcceptanceTester $I
     */
    public function __construct($navigateOrNot, $I)
    {
        parent::__construct($navigateOrNot, $I, '/profile');

        $this->tester = $I;
        $this->addPhotoLocator = 'input[name="user_photo"]';
        $this->photoLocator = '.avatar-img';
    }

    /**
     * Method for logout from current user profile
     * User will be directed to /login page
     */
    public function logout()
    {
        $this->hrefTop->click();
        $this->tester->waitForElementNotVisible('input[name="user_photo"]', 15);
    }

    /**
     * Method for changing current user password
     * @param $password String that contains allowed for password field symbols
     */
    public function changePasswordTo($password)
    {
        $this->password->fillField($password);
        $this->repeatPassword->fillField($password);
        $this->submitButton->click();
    }

    /**
     * Method for adding user photo to current profile
     * Will pass if error message is not shown(no ability to check in another way now)
     */
    public function attachPhoto()
    {
        $this->tester->attachFile($this->addPhotoLocator, 'juve.png');
        $this->submitButton->click();
        $this->tester->dontSee('Can\t upload file. Please, try later.', $this->error->getLocator());
    }
}