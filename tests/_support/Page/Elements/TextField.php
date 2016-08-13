<?php
namespace Page\Elements;
use Codeception\Exception\ElementNotFound;
use Facebook\WebDriver\Exception\InvalidSelectorException;
use Facebook\WebDriver\Exception\NoSuchElementException;
use Facebook\WebDriver\WebDriverBy;

/**
 * Class TextField
 * @package Page\Elements
 */
class TextField
{
    private $instance;
    private $locator;
    private $k;

    /**
     * @param $locator
     * @param $I \AcceptanceTester
     */
    public function __construct($locator, $I)
    {
        $this->instance = $I;
        $this->locator = $locator;
    }

    public function fillField($text)
    {
        $this->instance->fillField($this->locator, $text);
    }

    public function appendField($text)
    {
        $this->instance->appendField($this->locator, $text);
    }

    public function getText()
    {
        return $this->instance->grabTextFrom($this->locator);
    }

    public function getLocator()
    {
        return $this->locator;
    }
    /**
     * @param $key - could be an array - for buttons combinations or single key
     */
    public function clickButtonOnField($keyOrArray)
    {
        if (!isset($keyOrArray)) {
            $this->instance->pressKey($this->locator, $keyOrArray);
        }
    }

    public function getPlaceholder()
    {
        return $this->instance->grabAttributeFrom($this->locator, 'placeholder');
    }

    public function getLength()
    {
        return $this->instance->grabAttributeFrom($this->locator, 'size');
    }

    public function getValue()
    {
        return $this->instance->grabAttributeFrom($this->locator, 'value');
    }
    
    public function isVisible()
    {
        $this->instance->executeInSelenium(function (\Facebook\WebDriver\WebDriver $webDriver) {
            $this->k = 0;
            try {
                $webDriver->findElement(WebDriverBy::cssSelector($this->locator));
            }catch (InvalidSelectorException $e){
                $this->k += 1;
            }catch (ElementNotFound $e) {
                $this->k += 1;
            }catch (NoSuchElementException $e) {
                $this->k += 1;
            }
            try {
                $webDriver->findElement(WebDriverBy::xpath($this->locator));
            }catch (InvalidSelectorException $e){
                $this->k += 1;
            }catch (ElementNotFound $e){
                $this->k += 1;
            }catch (NoSuchElementException $e) {
                $this->k += 1;
            }
            try {
                $webDriver->findElement(WebDriverBy::name($this->locator));
            }catch (InvalidSelectorException $e){
                $this->k += 1;
            }catch (ElementNotFound $e){
                $this->k += 1;
            }catch (NoSuchElementException $e) {
                $this->k += 1;
            }
            try {
                $webDriver->findElement(WebDriverBy::linkText($this->locator));
            }catch (InvalidSelectorException $e){
                $this->k += 1;
            }catch (ElementNotFound $e){
                $this->k += 1;
            }catch (NoSuchElementException $e) {
                $this->k += 1;
            }
        });
        if ($this->k < 4){
            return true;
        }else{
            return false;
        }
    }

}

