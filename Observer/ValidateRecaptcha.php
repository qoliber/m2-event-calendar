<?php
/**
 * Created by Qoliber
 *
 * @category    Qoliber
 * @package     Qoliber_EventCalendar
 * @author      Jakub Winkler <jwinkler@qoliber.com>
 */

declare(strict_types=1);

namespace Qoliber\EventCalendar\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\LocalizedException;
use Magento\ReCaptchaUi\Model\CaptchaResponseResolverInterface;
use Magento\ReCaptchaUi\Model\IsCaptchaEnabledInterface;
use Magento\ReCaptchaUi\Model\ValidationConfigResolverInterface;
use Magento\ReCaptchaValidationApi\Api\ValidatorInterface;

class ValidateRecaptcha implements ObserverInterface
{
    /**
     * @param \Magento\ReCaptchaUi\Model\IsCaptchaEnabledInterface $isCaptchaEnabled
     * @param \Magento\ReCaptchaUi\Model\ValidationConfigResolverInterface $validationConfigResolver
     * @param \Magento\ReCaptchaValidationApi\Api\ValidatorInterface $validator
     * @param \Magento\ReCaptchaUi\Model\CaptchaResponseResolverInterface $captchaResponseResolver
     */
    public function __construct(
        protected IsCaptchaEnabledInterface $isCaptchaEnabled,
        protected ValidationConfigResolverInterface $validationConfigResolver,
        protected ValidatorInterface $validator,
        protected CaptchaResponseResolverInterface $captchaResponseResolver
    ) {
    }

    /**
     * Execute Observer
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     *
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute(Observer $observer): void
    {
        $key = 'event_form';
        $request = $observer->getRequest();

        if ($this->isCaptchaEnabled->isCaptchaEnabledFor($key)) {
            $validationConfig = $this->validationConfigResolver->get($key);

            try {
                $reCaptchaResponse = $this->captchaResponseResolver->resolve($request);
            } catch (InputException $e) {
                throw new LocalizedException(__('Please complete the reCAPTCHA validation.'));
            }

            $validationResult = $this->validator->isValid($reCaptchaResponse, $validationConfig);

            if (false === $validationResult->isValid()) {
                throw new LocalizedException(__('reCAPTCHA validation failed. Please try again.'));
            }
        }
    }
}
