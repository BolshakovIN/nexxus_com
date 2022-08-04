<?php

namespace Helper;

use Codeception\Exception\ModuleException;
use Codeception\Lib\ModuleContainer;
use Codeception\Module;
use Codeception\TestInterface;
use Exception;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Page\Credentials;
use ReflectionClass;
use ReflectionException;

class Acceptance extends Module
{
    private Module\WebDriver $webDriver;

    /**
     * @throws ModuleException
     */
    public function __construct(ModuleContainer $moduleContainer, $config = null)
    {
        parent::__construct($moduleContainer, $config);
        /** @var Module\WebDriver $webDriver*/
        $webDriver = $this->getModule('WebDriver');
        $this->webDriver = $webDriver;
    }

    /**
     * Метод кликает по элементу после ожидания его кликабельности
     *
     * @param string $elementSelector - локатор элемента
     * @param int $timeout - время ожидания пока элемент не станет активным
     * @return void
     *
     * @throws Exception
     */
    public function clickOnElementAfterWaitingItClickable(string $elementSelector, int $timeout = 15): void
    {
        $this->webDriver->waitForElementClickable($elementSelector, $timeout);
        $this->webDriver->click($elementSelector);
    }

    /**
     * Метод ожидает отображения элемента на странице и заполняет текстовое поле строкой
     *
     * @param string $elementSelector - локатор элемента
     * @param string $textValue - текстовое значение
     * @param int $timeout - время ожидания пока элемент не станет видимым
     * @return void
     *
     * @throws Exception
     */
    public function fillFieldAfterWaitingElementVisible(string $elementSelector, string $textValue, int $timeout = 15): void
    {
        $this->webDriver->waitForElementVisible($elementSelector, $timeout);
        $this->webDriver->fillField($elementSelector, $textValue);
    }

    /**
     * Метод ставит флажок после ожидания кликабельности элемента на странице
     *
     * @param string $elementSelector - локатор элемента
     * @param int $timeout - время ожидания пока элемент не станет кликабельным
     * @return void
     *
     * @throws Exception
     */
    public function checkOptionAfterWaitForElementClickable(string $elementSelector, int $timeout = 15): void
    {
        $this->webDriver->waitForElementClickable($elementSelector, $timeout);
        $this->webDriver->checkOption($elementSelector);
    }

    /**
     * Метод выбирает элемент в селекторе или группе радиобаттонов после ожидания кликабельности элемента на странице
     *
     * @param string $elementSelector - локатор элемента
     * @param string $elementName - название элемента
     * @param int $timeout - время ожидания пока элемент не станет кликабельным
     * @return void
     *
     * @throws Exception
     */
    public function selectOptionAfterWaitForElementClickable(string $elementSelector, string $elementName, int $timeout = 15): void
    {
        $this->webDriver->waitForElementClickable($elementSelector, $timeout);
        $this->webDriver->selectOption($elementSelector, $elementName);
    }

    /**
     * Заполнить поле с задержкой
     * имитируя поведение человека и не тригеря сканер
     *
     * ``` php
     * <?php
     * $I->fillFieldWithDelay("//input[@type='text']", "Hello World!", 100);
     * $I->fillFieldWithDelay(['name' => 'email'], 'jon@example.com', 100);
     * ?>
     * ```
     *
     * @param $field
     * @param $text
     * @param [$delay] - задержка в миллисекундах (но не меньше 60)
     *
     * @see \Codeception\Module\WebDriver::type
     */
    public function fillFieldWithDelay($field, $text, $delay = 60)
    {
        $delayInMicroSeconds = $delay * 1000;
        $I = $this->webDriver;
        $I->clearField($field);
        $I->click($field);
        $I->executeInSelenium(function (RemoteWebDriver $webDriver) use ($text, $delayInMicroSeconds) {
            foreach (mb_str_split($text) as $key) {
                usleep($delayInMicroSeconds);
                $webDriver->getKeyboard()->sendKeys($key);
            }
            usleep($delayInMicroSeconds);
        });
    }

    /**
     * Ожидает алерт
     *
     * @param int $secondToWait - время ожидания алерта в секундах
     */
    public function waitForPopup(int $secondToWait = 15)
    {
        try {
            $this->webDriver->executeInSelenium(function (RemoteWebDriver $webdriver) use ($secondToWait) {
                $webdriver->wait($secondToWait, 200)->until(
                    WebDriverExpectedCondition::alertIsPresent()
                );
            });
        } catch (Exception) {
        }
    }

    /**
     * Ожидает алерт и принимает его
     *
     * @param int $numberOfAlerts - количество необходимых алертов
     */
    public function acceptAlert(int $numberOfAlerts = 1, int $secondToWait = 15)
    {
        while ($numberOfAlerts > 0) {
            $this->waitForPopup($secondToWait);
            $this->webDriver->executeInSelenium(function (RemoteWebDriver $webDriver) {
                $webDriver->switchTo()->alert()->accept();
            });
            $numberOfAlerts--;
        }
    }

    /**
     * Возвращает текущий URL страницы
     *
     * @return mixed|null
     */
    public function getCurrentURL(): mixed
    {
        return $this->webDriver->executeInSelenium(function (RemoteWebDriver $webDriver) {
            return $webDriver->getCurrentURL();
        });
    }

    /**
     * Получить имя генерируемого фрейма (работает если на странице только 1 фрейм)
     */
    public function getDynamicallyIFrameName()
    {
        return $this->webDriver->executeInSelenium(function (RemoteWebDriver $webdriver) {
            return $webdriver->findElements(WebDriverBy::tagName('iframe'))[0]->getAttribute('name');
        });
    }

    /**
     * Ожидает открытие нового окна и переходит к нему
     *
     * @param int $timeout - таймаут ожидания
     */
    public function waitNewOpenWindow(int $timeout = 10)
    {
        $newWindowOpen = false;
        $quantityOpenWindow = $this->webDriver->executeInSelenium(function (RemoteWebDriver $webDriver) {
            $quantityOpenWindow = $webDriver->getWindowHandles();

            return count($quantityOpenWindow);
        });
        while (!$newWindowOpen and $timeout > 0) {
            $newWindowOpen = $this->webDriver->executeInSelenium(
                function (RemoteWebDriver $webDriver) use ($quantityOpenWindow) {
                    $window = count($webDriver->getWindowHandles());
                    if ($window > $quantityOpenWindow) {
                        $this->webDriver->switchToNextTab();

                        return true;
                    }

                    return false;
                }
            );
            $timeout -= 0.1;
            $this->webDriver->wait(0.1);
        }
    }

    /**
     * Ожидает открытие указанного кол-ва окон
     *
     * @param $numberOfWindow - кол-во открытых окон
     * @param int $timeout - таймаут ожидания
     */
    public function waitAllOpenWindows($numberOfWindow, int $timeout = 30)
    {
        $elements = 0;
        while ($numberOfWindow > $elements and $timeout > 0) {
            $elements = $this->webDriver->executeInSelenium(function (RemoteWebDriver $webDriver) {
                $window = $webDriver->getWindowHandles();

                return count($window);
            });
            $timeout -= 0.1;
            $this->webDriver->wait(0.1);
        }
    }

    /**
     * Перейти к активному окну
     */
    public function goToActiveWindow()
    {
        $this->webDriver->executeInSelenium(function (RemoteWebDriver $webdriver) {
            $handles = $webdriver->getWindowHandles();
            $last_window = end($handles);
            $webdriver->switchTo()->window($last_window);
        });
    }

    /**
     * Получить значение константы класса
     *
     * @param string $objectOrClass - имя класса (можно передать __CLASS__)
     * @param string $nameConstant - имя константы
     * @return mixed
     * @throws ReflectionException
     */
    public static function getConstant(string $objectOrClass, string $nameConstant): mixed
    {
        $classObject = new ReflectionClass($objectOrClass);
        return $classObject->getConstant($nameConstant);
    }

    /**
     * Функция для проверки итерационно
     *
     * @param callable $whatWeCheck - что проверяем
     * @param callable|null $whatDoWeDoIfThereIsError - что делаем, если ошибка
     * @param string $error - ошибка во время итерации
     * @param int $max - количество итераций
     *
     * @return mixed - возвращает результат выполнения $whatWeCheck или null
     */
    public function waitDuringIteration(
        callable $whatWeCheck,
        string $error = 'Ошибка во время итерации',
        int $max = 15,
        callable $whatDoWeDoIfThereIsError = null
    ): mixed {
        if (empty($whatDoWeDoIfThereIsError)) {
            $whatDoWeDoIfThereIsError = function () {
                $this->webDriver->wait(5);
            };
        }

        $i = 0;
        $hasError = true;
        $resultWhatWeCheck = '';
        while ($i < $max) {
            try {
                $resultWhatWeCheck = $whatWeCheck();
                $hasError = false;
                break;
            } catch (Exception) {
                $whatDoWeDoIfThereIsError();
                $i++;
            }
        }
        if ($hasError) {
            $this->webDriver->assertTrue(false, $error);
        }
        return $resultWhatWeCheck;
    }
}
