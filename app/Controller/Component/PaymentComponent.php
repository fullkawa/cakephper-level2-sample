<?php
Configure::load('payment.php'); // 設定ファイルに加盟店ID等を記述する

class PaymentComponent extends Component {

    /**
     * あるキャリアの決済認可要求処理
     *
     * @param string $accountTimingKbn 課金タイミング区分
     * @param string $firstAccountDay 初回課金年月日
     * @param string $firstAmount 初回金額
     * @param string $nextAmount 次回以降金額
     * @param string $memberAuthOkUrl 認証OK加盟店URL
     * @param string $memberAuthNgUrl 認証NG加盟店URL
     * @param array $options
     *     'openId'         => OpenID
     *     'accountTiming'  => 課金タイミング
     *     'commodity'      => 摘要
     *     'memberManageNo' => 加盟店管理番号
     *     'serviceName'    => サービス名
     *     'serviceTel'     => サービス電話番号
     *     'contentsId'     => コンテンツID
     *
     * @return array $res_params 決済認可要求の結果
     *     'transactionId'  => トランザクションID
     */
    public function payCertForContBill($accountTimingKbn, $firstAccountDay, $firstAmount, $nextAmount, $memberAuthOkUrl,
            $memberAuthNgUrl, $options = array()) {
        // 省略
    }
}