<?php

namespace Modules\Payment;

class BookeeyPay
{
    protected $curl;
    protected $endpoint = 'https://pg.bookeey.com/internalapi/api/';
    protected $devcType = "SYSTEM";
    protected $crossCat = "GEN";
    protected $payfor;
    protected $productId;
    protected $merchantId;
    protected $subMerchantId;
    protected $appType;
    protected $appVersion;
    protected $apiVersion;
    protected $secretKey;
    protected $dbrqst;

    public function __construct($endpoint = null)
    {
        if (!is_null($endpoint)) {
            $this->endpoint = (string) $endpoint;
        }

        $this->payfor = "";
        $this->productId = "";
        $this->merchantId = "";
        $this->subMerchantId = "";
        $this->appType = "";
        $this->appVersion = "";
        $this->apiVersion = "";
        $this->dbrqst = "";
        $this->secretKey = "";
    }

    public function getPayFor()
    {
        return $this->payfor;
    }

    public function setPayFor($for)
    {
        $this->payfor = $for;
    }

    public function getDbRqst()
    {
        return $this->dbrqst;
    }

    public function setDbRqst($rqst)
    {
        $this->dbrqst = $rqst;
    }

    public function getSecretKey()
    {
        return $this->secretKey;
    }

    public function setSecretKey($key)
    {
        $this->secretKey = $key;
    }

    public function getProductId()
    {
        return $this->productId;
    }

    public function setProductId($id)
    {
        $this->productId = $id;
    }

    public function getMerchantId()
    {
        return $this->merchantId;
    }

    public function setMerchantId($uid)
    {
        $this->merchantId = $uid;
    }

    public function getSubMerchantId()
    {
        return $this->subMerchantId;
    }

    public function setSubMerchantId($uid)
    {
        $this->subMerchantId = $uid;
    }

    public function getAppType()
    {
        return $this->appType;
    }

    public function setAppType($type)
    {
        $this->appType = $type;
    }

    public function getAppVersion()
    {
        return $this->appVersion;
    }

    public function setAppVersion($ver)
    {
        $this->appVersion = $ver;
    }

    public function getApiVersion()
    {
        return $this->apiVersion;
    }

    public function setApiVersion($ver)
    {
        $this->apiVersion = $ver;
    }

    /**
     * Data object for transaction details
     * Data object transaction headers
     * Data object for merchant details
     * @param array $request
     * @return array headers
     */
    private function paymentCreateRequestParam($request)
    {
        $headers = [];

        $headers['Do_TxnDtl'] = array(
            array(
                "SubMerchUID" => $this->getSubMerchantId(),
                "Txn_AMT" => (string) $request['amount'],
            ),
        );

        $headers['Do_TxnHdr'] = array(
            "PayFor" => $this->getPayFor(),
            "Txn_HDR" => (string) $request['merchant_txn_id'],
            "PayMethod" => (string) $request['payment_method'],
            "BKY_Txn_UID" => "",
            "Merch_Txn_UID" => (string) $request['merchant_txn_id'],
            "hashMac" => $this->generateHashMac($request),
        );

        $headers['Do_Appinfo'] = array(
            "APPTyp" => $this->getAppType(),
            "OS" => PHP_OS,
            "DevcType" => $this->devcType,
            "IPAddrs" => "",
            "Country" => "",
            "AppVer" => $this->getAppVersion(),
            "UsrSessID" => (string) $request['user_session_id'],
            "APIVer" => $this->getApiVersion(),
            "APPID" => "",
            "MdlID" => "",
        );

        $headers['Do_PyrDtl'] = array(
            "Pyr_MPhone" => (string) $request['customer_phone'],
            "Pyr_Name" => $request['customer_name'],
        );

        $headers['Do_MerchDtl'] = array(
            "BKY_PRDENUM" => $this->getProductId(),
            "FURL" => $request['failure_url'],
            "MerchUID" => $this->getMerchantId(),
            "SURL" => $request['success_url'],
        );

        $headers['DBRqst'] = $this->getDbRqst();
        
        $headers['Do_MoreDtl'] = array(
            "Cust_Data1" => "",
            "Cust_Data2" => "",
            "Cust_Data3" => "",
        );

        return json_encode($headers, JSON_UNESCAPED_SLASHES);
    }

    /**
     * @param string $path
     * @return string adds the path to endpoint with.
     */
    private function build_api_call_url($path)
    {
        if (strpos($path, '/?') === false and strpos($path, '?') === false) {
            return $this->endpoint . $path;
        }

        return $this->endpoint . $path;
    }

    /**
     * @param string $method ('GET', 'POST', 'DELETE', 'PATCH')
     * @param string $path whichever API path you want to target.
     * @param array $data contains the POST data to be sent to the API.
     * @return array decoded json returned by API.
     */
    private function api_call($method, $path, $data = null)
    {
        $path = (string) $path;
        $method = (string) $method;
        $request_url = $this->build_api_call_url($path);

        $options = array();
        $options[CURLOPT_HTTPHEADER] = array('Content-Type:application/json');
        $options[CURLOPT_RETURNTRANSFER] = true;
        $options[CURLOPT_ENCODING] = "";
        $options[CURLOPT_MAXREDIRS] = 10;
        $options[CURLOPT_TIMEOUT] = 30;
        if ($method == 'POST') {
            $options[CURLOPT_POST] = 1;
            $options[CURLOPT_CUSTOMREQUEST] = "POST";
            $options[CURLOPT_POSTFIELDS] = $data;
        } elseif ($method == 'DELETE') {
            $options[CURLOPT_CUSTOMREQUEST] = 'DELETE';
        } elseif ($method == 'PATCH') {
            $options[CURLOPT_POST] = 1;
            $options[CURLOPT_POSTFIELDS] = $data;
            $options[CURLOPT_CUSTOMREQUEST] = 'PATCH';
        } elseif ($method == 'GET' or $method == 'HEAD') {
            if (!empty($data)) {
                $options[CURLOPT_CUSTOMREQUEST] = "GET";
                $options[CURLOPT_POSTFIELDS] = $data;
            }
        }
        $options[CURLOPT_URL] = $request_url;
        $options[CURLOPT_SSL_VERIFYPEER] = true;
        $this->curl = curl_init();
        $setopt = curl_setopt_array($this->curl, $options);
        $response = curl_exec($this->curl);
        $headers = curl_getinfo($this->curl);
        $error_number = curl_errno($this->curl);
        $error_message = curl_error($this->curl);
        $response_obj = json_decode($response, true);
        if ($error_number != 0) {
            if ($error_number == 60) {
                throw new \Exception("Something went wrong. cURL raised an error with number: $error_number and message: $error_message. " .
                    "Please check http://stackoverflow.com/a/21114601/846892 for a fix." . PHP_EOL);
            } else {
                throw new \Exception("Something went wrong. cURL raised an error with number: $error_number and message: $error_message." . PHP_EOL);
            }
        }
        return $response_obj;
    }

    /**
     * Payment Request Link Create method.
     * @param array $payment_request
     * @return array single PaymentRequest object.
     */
    public function paymentRequestLinkCreate(array $payment_request)
    {
        $request = $this->paymentCreateRequestParam($payment_request);
        $response = $this->api_call('POST', 'payment/requestLink', $request);
        return $response;
    }

    /**
     * Generate random number method
     * @return integer random number
     */
    private function generateRandomNmber($size = 8)
    {
        $number = '';
        $count = 0;
        while ($count < $size) {
            $digit = mt_rand(0, 9);
            $number .= $digit;
            $count++;
        }
        return $number;
    }

    /**
     * Generate Hash Mac method.
     * @param array $data
     * @return string hashMac
     */
    private function generateHashMac($data)
    {
        $secret = $this->getSecretKey();
        $string = $this->getMerchantId();
        $string .= "|";
        $string .= $data['merchant_txn_id'];
        $string .= "|";
        $string .= $data['success_url'];
        $string .= "|";
        $string .= $data['failure_url'];
        $string .= "|";
        $string .= $data['amount'];
        $string .= "|";
        $string .= $this->crossCat;
        $string .= "|";
        $string .= $secret;
        $string .= "|";
        $string .= $data['merchant_txn_id'];
        $sig = hash_hmac('sha512', $string, $secret);
        return $sig;
    }

}
