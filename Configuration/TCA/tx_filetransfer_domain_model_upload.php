<?php

declare(strict_types=1);

return [
    'ctrl' => [
        'title' => 'LLL:EXT:filetransfer/Resources/Private/Language/locallang_db.xlf:tx_filetransfer_domain_model_upload',
        'label' => 'subject',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'versioningWS' => false,
        'iconfile' => 'EXT:filetransfer/Resources/Public/Icons/Extension.gif',
        'origUid' => 't3_origuid',
        'adminOnly' => true
    ],
    'columns' => [
        'sender_address' => [
            'label' => 'LLL:EXT:filetransfer/Resources/Private/Language/locallang_db.xlf:tx_filetransfer_domain_model_upload.sender_address',
            'config' => [
                'type' => 'email',
            ],
        ],
        'receiver_address' => [
            'label' => 'LLL:EXT:filetransfer/Resources/Private/Language/locallang_db.xlf:tx_filetransfer_domain_model_upload.receiver_address',
            'config' => [
                'type' => 'email',
            ],
        ],
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
            'exclude' => true,
            'config' => [
                'type' => 'input',
                'size' => 20,
                'eval' => 'trim',
                'readonly' => true,
                'max' => 80,
            ],
        ],
        'download_limit' => [
            'label' => 'LLL:EXT:filetransfer/Resources/Private/Language/locallang_db.xlf:tx_filetransfer_domain_model_upload.download_limit',
            'config' => [
                'type' => 'number',
                'format' => 'integer',
                'readonly' => true,
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
                'readonly' => true,
            ],
        ],
        'validity_duration' => [
            'label' => 'LLL:EXT:filetransfer/Resources/Private/Language/locallang_db.xlf:tx_filetransfer_domain_model_upload.validity_date',
            'config' => [
                'type' => 'number',
                'format' => 'integer',
                'default' => 3,
                'range' => [
                    'lower' => 3,
                ],
            ],
        ],
    ],
    'types' => [
        0 => ['showitem' => 'sender_address,receiver_address,subject,message,asset,validity_duration,validity_date,download_limit,token'],
    ],
];
