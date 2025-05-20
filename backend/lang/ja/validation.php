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
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
      |--------------------------------------------------------------------------
      | Custom Validation Attributes
      | カスタム検証属性
      |--------------------------------------------------------------------------
      |
      | The following language lines are used to swap attribute place-holders
      | with something more reader friendly such as E-Mail Address instead
      | of "email". This simply helps us make messages a little cleaner.
      |
      | 次の言語行は、属性プレースホルダを「email」ではなく「E-Mail Address」などの
      | 読みやすいものと交換するために使用されます。
      |
    */

    'attributes' => [
        'user_id' => 'ユーザーID',
        'user_name' => '氏名',
        'user_type' => 'ユーザ種別',
        'master_id' => 'マスタID',
        'master_name' => '項目名称',
        'email' => 'メールアドレス',
        'email_confirmation' => 'メールアドレス（確認用）',
        'item_id' => 'アイテムID',
        'item_code01' => '識別０１',
        'item_code02' => '識別０２',
        'item_code03' => '識別０３',
        'item_code04' => '識別０４',
        'item_code05' => '識別０５',
        'item_value01' => '名称０１',
        'item_value02' => '名称０２',
        'item_value03' => '名称０３',
        'item_value04' => '名称０４',
        'item_value05' => '名称０５',
        'item_number01' => '数値０１',
        'item_number02' => '数値０２',
        'item_number03' => '数値０３',
        'sort_seq' => '順序',
        'log_level' => 'ログレベル',
        'search_from_date' => '検索日(開始)',
        'search_to_date' => '検索日(終了)',
        'group_id' => 'グループID',
        'max_levels' => 'カラム内上限数',
        'size_per_sim_gb' => 'シミュレーション実行時割り当てGB数',
        'sim_split_digits' => 'シミュレーション実行時枝番数',
        'job_time_max' => 'ジョブ実行終了時間',
        'parallels' => '同時最大実行数',
        'delimiter' => '区切り文字',
        'random_seed' => '乱数種',
        'input_sample_size' => 'サンプルサイズ',
        'unit_sample_size' => '1ファイルあたりサンプルサイズ',
        'sharing_method' => '共有方法',
        'page' => 'ページ',
        'calc_id' => '計算ID',
        'tenant_id' => 'テナントID',
        'area_kbn' => '地区区分',
        'file_type' => 'ファイル種別',
        'file_name' => '入力ファイル名',
        'file_path' => 'ファイルパス',
        'calc_status' => 'ステータス',
        'char_code' => '文字コード',
        'skip_rows' => '先頭スキップ行数',
        'head_row' => 'ヘッダ行',
        'import_target' => '取込対象',
    ],
];
