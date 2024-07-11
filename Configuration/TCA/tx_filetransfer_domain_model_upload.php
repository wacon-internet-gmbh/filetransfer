<?php

declare(strict_types=1);

return [
    'ctrl' => [
        'title' => 'LLL:EXT:filetransfer/Resources/Private/Language/locallang_db.xlf:tx_filetransfer_domain_model_upload',
        'label' => 'subject',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'versioningWS' => true,
        'delete' => 'deleted',
        'iconfile' => 'EXT:filetransfer/Resources/Public/Icons/Extension.gif',
        'origUid' => 't3_origuid',
        'hideTable' => true,
    ],
    'columns' => [
        'subject' => [
            'label' => 'LLL:EXT:filetransfer/Resources/Private/Language/locallang_db.xlf:tx_filetransfer_domain_model_upload.subject',
            'config' => [
                'type' => 'input',
                'size' => 20,
                'eval' => 'trim',
                'required' => true,
                'max' => 255,
            ],
        ],
        'message' => [
            'label' => 'LLL:EXT:filetransfer/Resources/Private/Language/locallang_db.xlf:tx_filetransfer_domain_model_upload.message',
            'config' => [
                'type' => 'text',
                'eval' => 'trim',
                'required' => true,
            ],
        ],
        'token' => [
            'label' => 'LLL:EXT:filetransfer/Resources/Private/Language/locallang_db.xlf:tx_filetransfer_domain_model_upload.token',
            'config' => [
                'type' => 'input',
                'size' => 20,
                'eval' => 'trim',
                'readonly' => true,
                'max' => 80,
            ],
        ],
        'downloaded' => [
            'label' => 'LLL:EXT:filetransfer/Resources/Private/Language/locallang_db.xlf:tx_filetransfer_domain_model_upload.downloaded',
            'config' => [
                'type' => 'number',
                'readonly' => true,
                'range' => [
                    'lower' => 0,
                ]
            ],
        ],
        'asset' => [
            'label' => 'LLL:EXT:filetransfer/Resources/Private/Language/locallang_db.xlf:tx_filetransfer_domain_model_upload.asset',
            'config' => [
                'type' => 'file',
                'maxitems' => 1,
                'allowed' => 'zip,gz,gzip,tar',
            ],
        ],
        'validity_date' => [
            'label' => 'LLL:EXT:filetransfer/Resources/Private/Language/locallang_db.xlf:tx_filetransfer_domain_model_upload.validity_date',
            'config' => [
                'type' => 'datetime',
            ],
        ],
    ],
    'types' => [
        0 => ['showitem' => 'subject,message,asset,validity_date,downloaded,token'],
    ],
];
