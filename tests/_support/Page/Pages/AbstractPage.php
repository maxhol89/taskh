<?php
namespace Page\Pages;

use Page\Elements\Button;
use Page\Elements\Division;
use Page\Elements\Link;
use Page\Elements\TextField;

/**
 * Basic page - contains elements that available on all tested pages
 */
abstract class AbstractPage
{
    private $tester;

    public $hrefTop;
    public $de;
    public $en;
    public $ru;
    public $ua;
    public $formTitle;
    public $login;
    public $password;
    public $submitButton;
    public $year;
    public $formLocator;
    public $error;

    /**
     * AbstractPage constructor.
     * @param boolean $navigateOrNot
     * @param \AcceptanceTester $I
     * @param String $page
     */
    protected function __construct($navigateOrNot, $I, $page)
    {

        $this->tester = $I;

        if ($navigateOrNot) {
            $this->tester->amOnPage($page);
        }
        $this->formLocator = 'form';
        $this->hrefTop = new Link ('.menu-items>a', $this->tester);
        $this->de = new Link ('.language>a:nth-of-type(1)>img', $this->tester);
        $this->en = new Link ('.language>a:nth-of-type(2)>img', $this->tester);
        $this->ru = new Link ('.language>a:nth-of-type(3)>img', $this->tester);
        $this->ua = new Link ('.language>a:nth-of-type(4)>img', $this->tester);
        $this->formTitle = new Division ('.form>h1', $this->tester);
        $this->login = new TextField ('input[placeholder="Enter your login"]', $this->tester);
        $this->password = new TextField ('input[placeholder="Enter your password"]', $this->tester);
        $this->submitButton = new Button ('input[type="submit"]', $this->tester);
        $this->year = new Division ('#copyright', $this->tester);
        $this->error = new Division ('.form>.error:nth-of-type(1)', $this->tester);

    }

    /**
     * Method for checking whether the form title equals to expected
     * @param $title String title for the form for comparing with existing
     */
    public function checkTitle($title)
    {
        $this->tester->canSee($title, $this->formTitle->getLocator());
    }

    /**
     * Method for getting allowed symbols string of for login field from RegisterPage/ProfilePage
     * @param $length
     * @return string random String generated from chars
     */
    public static function returnValidLogin($length)
    {
        $chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ23456789_';
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $string .= substr($chars, rand(1, strlen($chars)) - 1, 1);
        }
        return $string;
    }

    /**
     * Method for getting non-allowed symbols string for the login field from RegisterPage/ProfilePage
     * @param $length
     * @return string random String generated from chars
     */
    public static function returnInvalidLogin($length)
    {
        $chars = '~`@#$%^&*()+|\\}{[]\'/.,?><-=;:"';
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $string .= substr($chars, rand(1, strlen($chars)) - 1, 1);
        }
        return $string;
    }

    /**
     * Method for getting allowed symbols string for the password field from RegisterPage/ProfilePage
     * @param $length
     * @return string random String generated from chars
     */
    public static function returnValidPassword($length)
    {
        $chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ23456789';
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $string .= substr($chars, rand(1, strlen($chars)) - 1, 1);
        }
        return $string;
    }

    /**
     * Method for getting non-allowed symbols string for the password field from RegisterPage/ProfilePage
     * @param $length
     * @return string random String generated from chars
     */
    public static function returnInvalidPassword($length)
    {
        $chars = '~`@#$%^&*()+|\\}{[]\'/.,?><-=;:"_';
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $string .= substr($chars, rand(1, strlen($chars)) - 1, 1);
        }
        return $string;
    }

    /**
     * Method for getting allowed symbols string for the email field from RegisterPage/ProfilePage
     * @param $length
     * @return string random String generated from chars
     */
    public static function returnValidMail($length)
    {
        $chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ23456789!#$%&\'*+-/=?^_`{|}.~';
        $charsWithoutDot = 'abdefhiknrstyzABDEFGHKNQRSTYZ23456789!#$%&\'*+-/=?^_`{|}~';
        $string = '';
        $string2 = '';
        while ($string == '' && $string2 == '' && !self::is_in_str($string, '..')) {
            for ($i = 0; $i < $length; $i++) {
                $string .= substr($chars, rand(1, strlen($chars)) - 1, 1);
            }
            for ($i = 0; $i < $length; $i++) {
                $string2 .= substr($charsWithoutDot, rand(1, strlen($charsWithoutDot)) - 1, 1);
            }
        }
        return $string2 . $string . 'a@gmail.com';
    }

    /**
     * Method for getting non-allowed string example for the email field from RegisterPage/ProfilePage
     * @return string random String generated from chars
     */
    public static function returnInvalidMail()
    {
        switch (mt_rand(0, 6)) {
            case 0 :
                return '@gmail.com';
                break;
            case 1 :
                return 'testtt';
                break;
            case 2 :
                return 'test@.com';
                break;
            case 3 :
                return 'test@gmail';
                break;
            case 4 :
                return 'tes..t@gmail.com';
                break;
            case 5 :
                return 'test.@gmail.com';
                break;
            case 6 :
                return '.test@gmail.com';
                break;
        }
        return false;
    }

    /**
     * Method for checking if the str contains substr
     * @param $str String whole string
     * @param $substr String string to search in $str
     * @return bool returns true if contains, else - false
     */
    private static function is_in_str($str, $substr)
    {
        $result = strpos($str, $substr);
        if ($result === FALSE)
            return false;
        else
            return true;
    }

}