<?php
return [
    'ctrl' => [
        'title'	=> 'LLL:EXT:mbit_effairs/Resources/Private/Language/locallang_db.xlf:tx_mbiteffairs_domain_model_subscriber',
        'label' => 'salutation',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
		'versioningWS' => true,
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
		'searchFields' => 'salutation,title,company,firstname,lastname,street,postcode,city,country,phone,fax,mobile,email,tracking',
        'iconfile' => 'EXT:mbit_effairs/Resources/Public/Icons/tx_mbiteffairs_domain_model_subscriber.gif'
    ],
    'types' => [
		'1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, salutation, title, company, firstname, lastname, street, postcode, city, country, phone, fax, mobile, email, tracking, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'],
    ],
    'columns' => [
		'sys_language_uid' => [
			'exclude' => true,
			'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
			'config' => ['type' => 'language'],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['', 0],
                ],
                'foreign_table' => 'tx_mbiteffairs_domain_model_subscriber',
                'foreign_table_where' => 'AND tx_mbiteffairs_domain_model_subscriber.pid=###CURRENT_PID### AND tx_mbiteffairs_domain_model_subscriber.sys_language_uid IN (-1,0)',
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
		't3ver_label' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.versionLabel',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
            ],
        ],
		'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.hidden',
            'config' => [
                'type' => 'check',
                'items' => [
                    '1' => [
                        '0' => 'LLL:EXT:core/Resources/Private/Language/locallang_core.xlf:labels.enabled'
                    ]
                ],
            ],
        ],
		'starttime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'input',
                'size' => 13,
                'eval' => 'datetime',
                'default' => 0,
                'renderType' => 'inputDateTime',
                ['behaviour' => ['allowLanguageSynchronization' => true]],
            ]
        ],
        'endtime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'input',
                'size' => 13,
                'eval' => 'datetime',
                'default' => 0,
                'range' => [
                    'upper' => mktime(0, 0, 0, 1, 1, 2038)
                ],
                'renderType' => 'inputDateTime',
                ['behaviour' => ['allowLanguageSynchronization' => true]]
            ],
        ],
        'salutation' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:mbit_effairs/Resources/Private/Language/locallang_db.xlf:tx_mbiteffairs_domain_model_subscriber.salutation',
	        'config' => [
			    'type' => 'select',
			    'renderType' => 'selectSingle',
			    'items' => [
			        ['-- Label --', 0],
			    ],
			    'size' => 1,
			    'maxitems' => 1,
			    'eval' => 'required'
			],
	    ],
	    'title' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:mbit_effairs/Resources/Private/Language/locallang_db.xlf:tx_mbiteffairs_domain_model_subscriber.title',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'company' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:mbit_effairs/Resources/Private/Language/locallang_db.xlf:tx_mbiteffairs_domain_model_subscriber.company',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'firstname' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:mbit_effairs/Resources/Private/Language/locallang_db.xlf:tx_mbiteffairs_domain_model_subscriber.firstname',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'lastname' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:mbit_effairs/Resources/Private/Language/locallang_db.xlf:tx_mbiteffairs_domain_model_subscriber.lastname',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim,required'
			],
	    ],
	    'street' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:mbit_effairs/Resources/Private/Language/locallang_db.xlf:tx_mbiteffairs_domain_model_subscriber.street',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'postcode' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:mbit_effairs/Resources/Private/Language/locallang_db.xlf:tx_mbiteffairs_domain_model_subscriber.postcode',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'city' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:mbit_effairs/Resources/Private/Language/locallang_db.xlf:tx_mbiteffairs_domain_model_subscriber.city',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'country' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:mbit_effairs/Resources/Private/Language/locallang_db.xlf:tx_mbiteffairs_domain_model_subscriber.country',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'phone' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:mbit_effairs/Resources/Private/Language/locallang_db.xlf:tx_mbiteffairs_domain_model_subscriber.phone',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'fax' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:mbit_effairs/Resources/Private/Language/locallang_db.xlf:tx_mbiteffairs_domain_model_subscriber.fax',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'mobile' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:mbit_effairs/Resources/Private/Language/locallang_db.xlf:tx_mbiteffairs_domain_model_subscriber.mobile',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'email' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:mbit_effairs/Resources/Private/Language/locallang_db.xlf:tx_mbiteffairs_domain_model_subscriber.email',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim,required'
			],
	    ],
	    'tracking' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:mbit_effairs/Resources/Private/Language/locallang_db.xlf:tx_mbiteffairs_domain_model_subscriber.tracking',
	        'config' => [
			    'type' => 'check',
			    'items' => [
			        '1' => [
			            '0' => 'LLL:EXT:core/Resources/Private/Language/locallang_core.xlf:labels.enabled'
			        ]
			    ],
			    'default' => 0
			]
	    ],
    ],
];
