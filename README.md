# Level2 プログラミング - CakePHP編 -

### Level1の定義

* 1. CakePHPで開発をすることができる。
* 2. UnitTestを書いたことがない。

### Level2の定義

* 1. CakePHP“らしい”コードを書くことができる。
* 2. “UnitTest”を書く。

Level1から2へレベルアップするために知っておくと良さそうなことを紹介します。

## 1. CakePHP“らしい”コードを書くことができる

### bakeで作成されるコードを見てみよう

```
～\app>Console\cake bake
```
※コマンドはコマンドプロンプト(Windows)で実行した場合のものです。

参照→["admin"プレフィクス付きで一通りbakeしました。](https://github.com/fullkawa/cakephper-level2-sample/commit/18678ffd115a77d87b26cdec0cde654a6887c26f)

### Controller

* ビジネスロジックは、MVC原理主義的にはModelに実装されるべきだが、Railsの流れを汲むフレームワークではControllerに実装される。  
参照→[『まつもと直伝　プログラミングのオキテ 第20回　MVCとRuby on Rails （7/7）』](http://itpro.nikkeibp.co.jp/article/COLUMN/20080610/307218/?ST=oss&P=7)
 * ```public function _methodName() { ...```と宣言することでブラウザから叩けないようにしつつ、UnitTestが可能になる。ここでビジネスロジックを実装する。
 * 使い回しができるロジックはComponent化(後述)する。
* UnitTestで必要なため、戻り値を必ずreturnすることを推奨する。

### CRUD

* CRUD = Create / Read / Update / Delete
* CakePHPでは以下の通り対応する。
 * Create = add
 * Read = index, view
 * Update = edit
 * Delete = delete
* 高水準な(業務に近い)操作はたいてい、CRUDのどれかに分類することができる。
 * 例1. 会員登録 = 会員情報のCreate あるいは 会員情報のUpdate
 * 例2. CSVダウンロード = Read(出力先がCSV形式のファイルなだけ)

### 「呼ぶ側」と「呼ばれる側」を意識する

* 呼ぶ側→Controller, 呼ばれる側→Model, View
* NGなコードの例
 * Controllerで検索条件等を組み立てる。  
 修正例(1)→[Controller内でconditionsを組み立てるのではなく、Model側の(マジック)メソッドで適切なデータを取得する方式に変更し…](https://github.com/fullkawa/cakephper-level2-sample/commit/53353b7b6ce3974988cc441cdeae01bb01ed49e0)  
 望ましい実装例(2)→[登録済ユーザを取得するメソッドを追加しました。](https://github.com/fullkawa/cakephper-level2-sample/commit/5486e774429f5ca112aedad77acc15636679ed21)  
* 上記がNGな理由：アクションメソッドの行数が多くなる・その検索条件でどんなデータを取得しているのか補足(コメント)が必要・テストができない

### Model

* メソッドのほとんどは「get～」という名称になるはず。
* NG) 必要な情報を取得する。  
OK) 取得される(＆公開してよい)情報をすべて取得し、View側で取捨選択する。
* 上記がNGな理由：再利用性が低くなる・View側に改修が入る度、Modelも改修が必要になる


### View

* ロジックは極力、Helper or Model or Controllerに実装する。
 * HTMLタグを含むものはHelperへ。
 * データに関する操作(随時、税込金額を計算する場合など)はModel::afterFind()等で行う。
* NGなコードの例
 * Viewで判定・表示状態の切替を行う。  
 修正例→["Delete"ボタン切り替えのロジックをHelperに移しました。](https://github.com/fullkawa/cakephper-level2-sample/commit/e068a83de48572d9b737b3cb8a44420d2af6416c)
* 特定の画面だけで必要となるCSS/JavascriptはViewで定義する。
```
<?php
echo $this->Html->css(PATH_TO_CSS_FILE, null, array('inline' => false));

echo $this->Html->script(PATH_TO_JAVASCRIPT_FILE, array('inline' => false));
?>
```
 * ともに、一つ目の引数を配列にすることで複数指定が可能。
 * 上記のように書く理由：必要ない画面での読み込みをなくすため・そのCSS/Javascriptを必要とするタグと関連付けるため。

### その他

#### Behavior

* いわゆる"Mixin"
* 既存のBehaviorで十分？
 * Acl, SoftDelete(論理削除)など

#### Component

* 使い回しができるロジックはComponentとして作成し、 *Component(＋設定ファイル)をコピーするだけで* 再利用できるようにする。  
参照→[Component作成・利用の例](https://github.com/fullkawa/cakephper-level2-sample/commit/697d0bba63076adcbbdfd1a2085ea61ec7bd7b78)
 * 案件に依存する記述を *一切* 入れない。  
 →処理に必要なパラメータはすべてComponent外部から渡しているため、他案件のシステムにコピーしてもComponentに修正は必要ない。  
 →仕様書に記載されているまま実装しているため、仕様変更があった場合に修正箇所を特定しやすいというメリットもある。  
 * 案件ごとに異なるパラメータを設定ファイルに持たせて、Controller側で読み込む。  
 →確認・修正箇所をまとめることができる。  
 →Controller側で読み込むことで、案件固有の処理(ユーザの種別によって金額が変わる等)を組み込む余地がある。  
 参照→[ユーザの種別に応じた初回金額を取得する処理を入れてみました。](https://github.com/fullkawa/cakephper-level2-sample/commit/de41ef004c1bbe150787436a8ace0e4ceecfb75c)  

#### Helper

* 表示形式の変更は既存のHelper(NumberHelper, TextHelper, TimeHelper)を利用する。
* 汎用的なHelperと特定のView専用のHelper？


#### Plugin

* 使い回したい一連の機能(キャリア決済など)はPluginとして作成する。


## 2. “UnitTest”を書く

### 入力と出力を意識する

* 情報処理の基本：入力→処理→出力
* 関数とは：引数と呼ばれるデータを受け取り、定められた通りの処理を実行して結果を返す一連の命令群(『[e-Words](http://e-words.jp/w/E996A2E695B0.html)』より)
* ユニットテストは、テスト対象メソッド(関数)にある引数を渡し、期待通りの結果が返ってくるかをチェックするもの。よって、基本に忠実にプログラミングすれば自ずとテスト可能なコードになっているはず。
* 結果≠処理結果コード/エラーコード
 * 参照渡しされた引数を直接編集し、処理結果コードを戻り値とする実装は *「旧時代のプログラミング作法」* である。
* ユニットテスト例→[User::isRegisted()のユニットテストを実装しました。](https://github.com/fullkawa/cakephper-level2-sample/commit/567a534aab7164e6d17d4586a34611b8b42ae8e1)


### 適切な名前を付ける

* 大原則：一つの関数で一つの処理を行う。
* “一つの処理”の内容を表す _過不足のない_ 言葉の選択が大事！  
→これができれば、関数の中身を読まなくてもよくなる。


## おまけ: さらに望ましい習慣

### プログラムを書かない

* プログラムを書くと必ず「時間(＝工数＝金)がかかる」「バグが生じる」。  
→すでに同様のPluginほかが作成されていないか、まず確認！


### 書き換えないで済むコードを書く

* 「呼ばれる側」のコードの話。
* “不具合”は修正(書き換え)されるべき。  
しかし、“仕様変更”には、基本、新規追加で対応すべき。  
そして、「呼ぶ側」にて新たに追加されたメソッドを呼ぶよう修正する。  


### 処理を一本道にする

* 典型的なメソッドの構造
```
public function getSomething($arg1) {
    $something = array(); // デフォルトの戻り値

    // 前処理(入力チェック)
    if (empty($arg1)) {
        // 不適切な引数が渡された場合は例外を投げて処理を中断する
        throw new Exception('arg1がありません。');
    }

    try {
        // 処理本体
        $result = do_something($arg1);
        if (!$result) {
            // 失敗したら例外を投げて処理を中断する
            throw new Exception('処理に失敗しました。');
        }
        $something = do_more($result);
        // 無事下まで辿り着いたとき、それがこの処理の正常系

    } catch (Exception $e) {
        // 例外をキャッチしたらログに出力する
        $this->log($e->getMessage(), LOG_WARNING);
    }
    return $something;
}
```

* 望ましくないメソッド構造
```
public function getSomething2($arg1) {
    // 省略

    // 処理本体
    $result = do_something($arg1);
    if ($result) {
        $something = do_more($result);
        return $something;
    } else {
        $this->log($e->getMessage(), LOG_WARNING);
        return false;
    }
    // 正常系を把握するためにはコードをじっくり読まないといけない！
}
```


### 同じFormatterを使う

* 誰も読まないコード規約でフォーマットを統一しようなんてナンセンス！


以上
