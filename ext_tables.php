<?php
defined('TYPO3') || die('Access denied.');
/**
 * FIX: no longer use of deprecated variable $extKey,
 * instead used extensionKey 'mbit_effairs'.
 */
call_user_func(
    function()
    {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'MbitEffairs',
            'Subscription',
            'Subscription'
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'MbitEffairs',
            'Unsubscription',
            'Unsubscription'
        );

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('mbit_effairs', 'Configuration/TypoScript', 'Effairs OptIn');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_mbiteffairs_domain_model_subscriber', 'EXT:mbit_effairs/Resources/Private/Language/locallang_csh_tx_mbiteffairs_domain_model_subscriber.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_mbiteffairs_domain_model_subscriber');

    },
    'mbit_effairs'
);
## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder