<?php
namespace Page\Elements;
use Codeception\Exception\ElementNotFound;
use Facebook\WebDriver\Exception\InvalidSelectorException;
use Facebook\WebDriver\Exception\NoSuchElementException;
use Facebook\WebDriver\WebDriverBy;

/**
 * Class Link
 * @package Page\Elements
 */
class Link
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

    public function click()
    {
        $this->instance->click($this->locator);
    }

    public function doubleClick()
    {
        $this->instance->doubleClick($this->locator);
    }

    public function getText()
    {
        return $this->instance->grabTextFrom($this->locator);
    }

    public function getHrefLink()
    {
        return $this->instance->grabAttributeFrom($this->locator,"href");
    }

    public function getLocator()
    {
        return $this->locator;
    }
    
    public function mouseMovementTo()
    {
        $this->instance->moveMouseOver($this->locator);
    }

    public function getElementClass()
    {
        return $this->instance->grabAttributeFrom($this->locator, 'class');
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

