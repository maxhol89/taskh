<?php
namespace Page\Pages;

use Page\Elements\Button;
use Page\Elements\Division;
use Page\Elements\Link;
use Page\Elements\TextField;

/**
 * Class RegistrationSuccessfulPage - class for page after successful registration of new user
 * @package Page\Pages
 */
class RegistrationSuccessfulPage extends AbstractPage
{
    private $tester;

    public $loginLink;
    public $successfulMessage;

    /**
     * RegistrationSuccessfulPage constructor.
     * @param \AcceptanceTester $I
     */
    public function __construct($I)
    {
        parent::__construct(false, $I, '');

        $this->tester = $I;

        $this->loginLink = new Link ('Click here to Log In.', $this->tester);
        $this->successfulMessage = new Division ('.form-content>div', $this->tester);
    }

}