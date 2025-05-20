<?php
// 共通定数
return [
    // ---------------------------------------------------------------------------------------
    // 汎用マスタのマスタID
    // ---------------------------------------------------------------------------------------
    'mcommonMasterid' =>[
        // システム全般
        'user_type' => 'C0001',         // ユーザ種別
        'rider_status_div' => 'C0024',  // ライダー状況区分
        'gcs_upload_path' => 'C0029',   // GoogleCloudStorage格納先（一時）

        // ドルフィン
        'bill_div' => 'C0010',          // 請求区分
        'slip_div' => 'C0012',          // 伝票区分
        'upload_file_type' => 'C8003',  // ファイル種類
    ],
    // ----------------------------------------------------------------------------------------
    // 画面機能ID
    // ----------------------------------------------------------------------------------------
    'functionId' => [
        'deliveryAllocation'    => 'SC10101',   // 配送手配
        'deliveryAllocationDetail' => 'SC10201', // 配送明細
        'deliveryPlaceDetail'   => 'SC10301',   // 配送先詳細
        'fileUpload'            => 'SA20101',   // 提出ファイルアップロード
        'fileUploadHistory'     => 'SA20102',   // ファイルアップロード履歴
    ],


    // 配送手配
    'deliveryAllocation' => [
        'completeStatus' => '4Z'
    ],

    // 配送明細
    'deliveryAllocationDetail' => [
        'completeSequence' => 5000.0
    ],

    // 配送先詳細
    'deliveryPlaceDetail' => [
        'receiveEndStatus' => 2,// 引取先
        'sendEndStatus' => 4999,// 荷届先
        // 関係先区分
        'askRelationDiv' => '1', // 依頼先
        'receiveRelationDiv' => '2', // 引取先
        'sendRelationDiv' => '4', // 荷届先
        'billingRelationDiv' => '5', // 請求先
        // 請求区分
        'cash' => '1', // 現金
        'electricPayment' => '4', // 電子決済
        // 配送ステータス
        'receiveProgress' => '41', // 引中
        'sendProgress' => '45', // 届中
        'waitObject' => '4X', // 荷待
        // 配送先区分
        'sendDiv' => '2' // 荷待
    ],
    
    // 配送履歴
    'deliveryHistory' => [
        'completeStatus' => '4Z',
        'completeSequence' => 5000.0,
        'pagination' => 5
    ],

    // ファイルアップロード
    'fileUpload' => [
        'gcs_upload_path_item_id' => '5', // 配送書類（領収書など）画像ファイル
    ],

    // ファイルアップロード履歴
    'fileUploadHistory' => [
        'period' => [
            'div' => [
                'todayDiv' => '0',         // 本日分(24h以内)
                'pastdayDiv'  => '1',      // 過去分
            ],
            'targetDay' => [
                'today' => 1,         // 本日分(24h以内)
                'pastday'  => 7,      // 過去分
            ],
        ],
        'pagination' => 5,
        'file_delete_val' => [
            'delete' => 0,
            'notDelete' => 1
        ],
    ],

    // ユーザ種別
    'userType' => [
        'member' => 0,   // メンバー
        'admin' => 1,    // システム管理者
        'operator' => 9, // 保守運用担当者
    ],


    // カスタムエクセプション
    'customError' => [
        'httpStatusCode' => [
            'customException' => 515,
        ],
        'errorMessage' => [
            'dbError' => 'データベースへの反映に失敗しました',
            'notFoundError' => 'リンク先がありません',
        ]
    ],

    'errorMessages' => [
        'I0001' => '{1} が更新されました。',
        'I0002' => '{1} が登録されました。',
        'I0003' => '{1} が完了しました。',

        'E0005' => '{1} を入力してください。',
        'E0007' => '{1} を選択してください。',
        'E0011' => '{1} の入力文字は {2} までとしてください。',
        'E0042' => '{1} に失敗しました。',
    ],

];