<?php
defined('TYPO3') || die('Access denied.');

call_user_func(
    function($extKey)
	{

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'MbitEffairs',
            'Subscription',
            [
                \MBIT\MbitEffairs\Controller\SubscriberController::class => 'new, create '
            ],
            // non-cacheable actions
            [
                \MBIT\MbitEffairs\Controller\SubscriberController::class => 'create'
            ]
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'MbitEffairs',
            'Unsubscription',
            [
                \MBIT\MbitEffairs\Controller\SubscriberController::class => 'unsubscribe, delete'
            ],
            // non-cacheable actions
            [
                \MBIT\MbitEffairs\Controller\SubscriberController::class => 'delete'
            ]
        );

	// wizards
	/** 
	 * FIX: No longer use of deprecated function \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath(),
	 * instead use EXT:extensionkey/.
	 */
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
		'mod {
			wizards.newContentElement.wizardItems.plugins {
				elements {
					subscription { 
						icon = EXT:' . $extKey . '/Resources/Public/Icons/user_plugin_subscription.svg
						title = LLL:EXT:mbit_effairs/Resources/Private/Language/locallang_db.xlf:tx_mbit_effairs_domain_model_subscription
						description = LLL:EXT:mbit_effairs/Resources/Private/Language/locallang_db.xlf:tx_mbit_effairs_domain_model_subscription.description
						tt_content_defValues {
							CType = list
							list_type = mbiteffairs_subscription
						}
					}
					unsubscription {
						icon = EXT:' . $extKey . '/Resources/Public/Icons/user_plugin_unsubscription.svg
						title = LLL:EXT:mbit_effairs/Resources/Private/Language/locallang_db.xlf:tx_mbit_effairs_domain_model_unsubscription
						description = LLL:EXT:mbit_effairs/Resources/Private/Language/locallang_db.xlf:tx_mbit_effairs_domain_model_unsubscription.description
						tt_content_defValues {
							CType = list
							list_type = mbiteffairs_unsubscription
						}
					}
				}
				show = *
			}
	   }'
	);
    },
    'mbit_effairs'
);
## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder