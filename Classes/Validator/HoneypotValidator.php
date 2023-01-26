<?php

namespace MBIT\MbitEffairs\Validator;

use TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Validation\Error;
class HoneypotValidator extends AbstractValidator
{
    /**
     * Validates the given value
     *
     * @param mixed $value
     * @return bool
     */
    public function isValid($value)
    {
        if (!empty(GeneralUtility::_GP('subject'))) {
            $error = new Error('Spam-Verdacht!', time());
            $this->result->forProperty('email')->addError($error);
            return false;
        }
        return true;
    }

}