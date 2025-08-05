<?php
// 共通定数
return [
    'home' => [
        'infoKindSlider' => 1,
        'infoKindGrid' => 2,
        'infoKindList' => 3,
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