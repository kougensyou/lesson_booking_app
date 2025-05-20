<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'batch:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'バッチテスト';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
$this->question("処理前使用メモリ：".memory_get_usage() / (1024 * 1024)."MB");
$time_start = microtime(true);

$dirPath = '/mnt/c/repo/_csv/';
$fileName1 = 'OCW_CABLE_ATTACH.csv'; // 1KB
$fileName2 = 'KBN_KOUSHIN.csv'; // 5M
$fileName22 = 'OCW_LSB_UNIT.csv';// 30M
$fileName3 = 'OCW_BUILDING.csv'; // 100M
$fileName4 = 'OCW_CABLE_FIGURE.csv'; // 500M
$fileName = $fileName3;
$csvPath = $dirPath . $fileName;

$this->question('ファイルサイズ：' . filesize($csvPath) / (1024 * 1024) . "MB");

        $this->line('バッチテスト開始');
        // \DB::beginTransaction();
        // $this->comment('Transaction');

        // csv取り込み処理
        $file = new \SplFileObject($csvPath);

        $file->setFlags(
            \SplFileObject::READ_CSV |           // CSV 列として行を読み込む
            \SplFileObject::READ_AHEAD |       // 先読み/巻き戻しで読み出す。
            \SplFileObject::SKIP_EMPTY |         // 空行は読み飛ばす
            \SplFileObject::DROP_NEW_LINE    // 行末の改行を読み飛ばす
        );

        $rowCount = 0;
        $datas = [];
        foreach ($file as $line) {
            // 文字コードを UTF-8 へ変換
            mb_convert_variables('UTF-8', 'sjis-win', $line);

            $datas[] = [
                'csv_name' => $fileName,
                'text1' => $line[0],
                'text2' => $line[1],
                'text3' => $line[2],
                'created_at' => Carbon::now(),
            ];

            if ($rowCount === 0) {
                // csvヘッダー
            } else if (count($datas) >= 5000) {
                \DB::beginTransaction();
                try {
                    \DB::table('test_csv_import')->insert($datas);
                    \DB::commit();
                } catch (\Exception $e) {
                    $this->question('rollback');
                    $this->error($e->getMessage());
                    \DB::rollback();
                }
                $datas = [];
            }

            $rowCount++;
        }

// 余りを登録
\DB::beginTransaction();
try {
    \DB::table('test_csv_import')->insert($datas);
    \DB::commit();
} catch (\Exception $e) {
    $this->question('rollback');
    $this->error($e->getMessage());
    \DB::rollback();
}


        // バッチ完了ログ
        try {
            // $this->comment('insert test_batch');
            \DB::table('test_batch')->insert([
                'batch_name' => $this->signature,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            \DB::commit();

            $this->info('commit');

        } catch (\Exception $e) {
            $this->question('rollback');
            $this->error($e->getMessage());
            \DB::rollback();
        }

        $this->line('バッチテスト終了');



$this->question('追加レコード数：' . $rowCount);

$time = microtime(true) - $time_start;
$this->question("処理時間：{$time} 秒");

$this->question("処理後メモリ使用量：".memory_get_usage() / (1024 * 1024)."MB");
$this->question("最大メモリ使用量：".memory_get_peak_usage() / (1024 * 1024)."MB");

// 実行コマンド php /mnt/c/repo/app/artisan 'batch:test'


    }
}
