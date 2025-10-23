<?php

return [

    /*
      |--------------------------------------------------------------------------
      | Validation Language Lines
      | 検証言語
      |--------------------------------------------------------------------------
      |
      | The following language lines contain the default error messages used by
      | the validator class. Some of these rules have multiple versions such
      | as the size rules. Feel free to tweak each of these messages here.
      |
      | 次の言語行には、バリデータークラスで使用されるデフォルトのエラーメッセージが含まれています。
      | これらの規則の中には、サイズ規則などの複数のバージョンがあります。
      | これらのメッセージのそれぞれをここで微調整してください。
    */

    'accepted'             => ':attribute が未承認です。',
    'active_url'           => ':attribute は有効なURLではありません。',
    'after'                => ':attribute は :date より後の日付にしてください。',
    'after_or_equal'       => ':attribute は :date 以降に設定してください。',
    'alpha'                => ':attribute は英字のみ有効です。',
    'alpha_dash'           => ':attribute は「英字」「数字」「-(ダッシュ)」「_(下線)」のみ有効です。',
    'alpha_num'            => ':attribute は「英字」「数字」のみ有効です。',
    'array'                => ':attribute は配列タイプのみ有効です。',
    'before'               => ':attribute は :date より前の日付にしてください。',
    'before_or_equal'      => ':attribute は :date 以前に設定してください。',
    'between'              => [
        'numeric' => ':attribute は :min ～ :max までの数値まで有効です。',
        'file'    => ':attribute は :min ～ :max キロバイトまで有効です。',
        'string'  => ':attribute は :min ～ :max 文字まで有効です。',
        'array'   => ':attribute は :min ～ :max 個まで有効です。',
    ],
    'boolean'              => ':attribute の値は true もしくは false のみ有効です。',
    'confirmed'            => ':attribute と確認用が一致していません。',
    'date'                 => ':attribute を有効な日付形式にしてください。',
    'date_equals'          => ':attribute は :date と日付を一致させてください。',
    'date_format'          => ':attribute 日付の形式に誤りがあります。',
    'different'            => ':attribute を :other と違うものにしてください。',
    'digits'               => ':attribute は :digits 桁のみ有効です。',
    'digits_between'       => ':attribute は :max 桁以下の半角数字で入力してください。',
    'dimensions'           => ':attribute ルールに合致する画像サイズのみ有効です。',
    'distinct'             => ':attribute に重複している値があります。',
    'email'                => ':attribute メールアドレスの書式のみ有効です。',
    'ends_with'            => ':attribute の文字列の最後は :values で終わる必要があります。',
    'exists'               => ':attribute 無効な値です。',
    'file'                 => ':attribute アップロード出来ないファイルです。',
    'filled'               => ':attribute 値を入力してください。',
    'gt'                   => [
        'numeric' => ':attribute は :value より大きい必要があります。',
        'file'    => ':attributeは :value キロバイトより大きい必要があります。',
        'string'  => ':attribute は :value 文字より多い必要があります。',
        'array'   => ':attribute には :value 個より多くの項目が必要です。',
    ],
    'gte'                  => [
        'numeric' => ':attribute の大小関係が不適切です。',
        'file'    => ':attribute は :value キロバイト以上である必要があります。',
        'string'  => ':attribute は :value 文字以上である必要があります。',
        'array'   => ':attribute には value 個以上の項目が必要です。',
    ],
    'image'                => ':attribute 画像は「jpg」「png」「bmp」「gif」「svg」のみ有効です。',
    'in'                   => ':attribute 無効な値です。',
    'in_array'             => ':attribute は :other と一致する必要があります。',
    'integer'              => ':attribute は整数のみ有効です。',
    'ip'                   => ':attribute IPアドレスの書式のみ有効です。',
    'ipv4'                 => ':attribute IPアドレス(IPv4)の書式のみ有効です。',
    'ipv6'                 => ':attribute IPアドレス(IPv6)の書式のみ有効です。',
    'json'                 => ':attribute 正しいJSON文字列のみ有効です。',
    'lt'                   => [
        'numeric' => ':attribute は :value 未満である必要があります。',
        'file'    => ':attribute は :value キロバイト未満である必要があります。',
        'string'  => ':attribute は :value 文字未満である必要があります。',
        'array'   => ':attribute は :value 未満の項目を持つ必要があります。',
    ],
    'lte'                  => [
        'numeric' => ':attribute の大小関係が不適切です。',
        'file'    => ':attribute は :value キロバイト以下である必要があります。',
        'string'  => ':attribute は :value 文字以下で入力してください。',
        'array'   => ':attribute は :value 以上の項目を持つ必要があります。',
    ],
    'max'                  => [
        'numeric' => ':attribute は :max 以下のみ有効です。',
        'file'    => ':attribute は :max KB以下のファイルのみ有効です。',
        'string'  => ':attribute の入力文字は :max までとしてください。',
        'array'   => ':attribute は :max 個以下のみ有効です。',
    ],
    'mimes'                => ':attribute は :values タイプのみ有効です。',
    'mimetypes'            => ':attribute は :values タイプのみ有効です。',
    'min'                  => [
        'numeric' => ':attribute は :min 以上のみ有効です。',
        'file'    => ':attribute は :min KB以上のファイルのみ有効です。',
        'string'  => ':attribute は :min 文字以上のみ有効です。',
        'array'   => ':attribute は :min 個以上のみ有効です。',
    ],
    'not_in'               => ':attribute 無効な値です。',
    'not_regex'            => 'The :attribute format is invalid.。',
    'numeric'              => ':attribute は半角数字で入力してください。',
    'present'              => ':attribute が存在しません。',
    'regex'                => ':attribute 無効な値です。',
    'required'             => ':attribute を入力してください。',
    'required_if'          => ':attribute は :other が :value には必須です。',
    'required_unless'      => ':attribute は :other が :values でなければ必須です。',
    'required_with'        => ':attribute は :values が入力されている場合は必須です。',
    'required_with_all'    => ':attribute は :values が入力されている場合は必須です。',
    'required_without'     => ':attribute は :values が入力されていない場合は必須です。',
    'required_without_all' => ':attribute は :values が入力されていない場合は必須です。',
    'same'                 => ':attribute は :other と同じ場合のみ有効です。',
    'size'                 => [
        'numeric' => ':attribute は :size のみ有効です。',
        'file'    => ':attribute は :size KBのみ有効です。',
        'string'  => ':attribute は :size 文字のみ有効です。',
        'array'   => ':attribute は :size 個のみ有効です。',
    ],
    'starts_with'          => ':attribute の文字列の最後は :values で終わる必要があります。',
    'string'               => ':attribute は文字列のみ有効です。',
    'timezone'             => ':attribute 正しいタイムゾーンのみ有効です。',
    'unique'               => ':attribute は既に存在します。',
    'uploaded'             => ':attribute アップロードに失敗しました。',
    'url'                  => ':attribute は正しいURL書式のみ有効です。',
    'uuid'                 => ':attribute は有効なUUIDではありません。',

    // カスタムバリデーションルール
    // app/Services/CustomValidator.php
    'alpha_numeric'         => ':attribute は半角英数字で入力してください。',
    'alphabet'              => ':attribute は英字で入力してください。',
    'mb_ok_numeric'         => ':attribute は数字で入力してください。',
    'zenkaku_ok'            => ':attribute は全角で入力してください。',
    'num_under'             => ':attribute は「数字」「_(下線)」のみ有効です。',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    | カスタム検証言語
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    | ここでは、行に名前を付けるために "attribute.rule"という規則を使って属性のカスタム
    | 検証メッセージを指定することができます。 これにより、特定の属性ルールに対して特定の
    | カスタム言語行をすばやく指定できます。
    |
    */

    'custom' => [
        'lesson_name' => [
            'required' => 'レッスンを選択してください',
        ],
        'new_password' => [
            'mismatch' => '新しいパスワードと確認用パスワードが一致しません。',
        ],
        'current_password' => [
            'invalid' => '現在のパスワードが正しくありません。',
        ],
        'image_url' => [
            'required' => '画像を選択してください',
        ],
    ],

    /*
      |--------------------------------------------------------------------------
      | Custom Validation Attributes
      |--------------------------------------------------------------------------
      |
      | The following language lines are used to swap attribute place-holders
      | with something more reader friendly such as E-Mail Address instead
      | of "email". This simply helps us make messages a little cleaner.
      |
    */

    'attributes' => [
        'lesson_category_name' => 'カテゴリー',
        'studio_name'          => 'スタジオ',
        'lesson_day'           => 'レッスン日',
        'lesson_time'          => 'レッスン時間',
        'lesson_name'          => 'レッスン名',
        'name'                 => '名前',
        'email'                => 'メールアドレス',
        'birth_date'           => '生年月日',
        'tel_no'               => '電話番号',
        'zip_code'             => '郵便番号',
        'address'              => '住所',
        'password'             => 'パスワード',
        'report_title'         => 'お問合せ件名',
        'report_email'         => '返信先メールアドレス',
        'report_contents'      => 'お問合せ内容',
        'current_password'     => '現在のパスワード',
        'new_password'         => '新しいパスワード',
        'new_password_confirmation' => '新しいパスワード(確認用)',
    ],
];
