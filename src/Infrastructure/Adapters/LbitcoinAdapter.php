<?php

namespace Infrastructure\Adapters;


class LbitcoinAdapter
{

    protected $hmac_auth_key;
    protected $secret;
    protected $client;

    private $baseApi = "https://localbitcoins.net";

    /**
     * LbitcoinAdapter constructor.
     * @param string $hmac_auth_key
     * @param string $secret
     */
    function __construct(string $hmac_auth_key, string $secret)
    {
        $this->hmac_auth_key = $hmac_auth_key;
        $this->secret = $secret;
    }


    /**
     * @param $pref
     * @param string $params
     * @return bool|string
     * @throws LbitcoinException
     */
    protected function sendQueryPost($pref, $params = "")
    {
        $nnce = time();
        $secrt = $this->secret;
        $auth_key = $this->hmac_auth_key;

        $addr = $this->baseApi . $pref;
        $queryData = $nnce . $auth_key . $pref . $params;
//dump($queryData);
        $signature = strtoupper(hash_hmac("sha256", $queryData, $secrt));
        $cont = array("Apiauth-Key: " . $auth_key, "Apiauth-Nonce: " . $nnce, "Apiauth-Signature: " . $signature);
//dump($cont);
//dump($addr);
        $zapr = curl_init($addr);
        curl_setopt($zapr, CURLOPT_POST, true);
        curl_setopt($zapr, CURLOPT_HTTPHEADER, $cont);
        curl_setopt($zapr, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($zapr, CURLOPT_CERTINFO, true);
        curl_setopt($zapr, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($zapr, CURLOPT_SSL_VERIFYHOST, false);


        if (!$response = curl_exec($zapr)) {
            $error = curl_error($zapr);
            curl_close($zapr);
            throw new LbitcoinException($error);
        }

        curl_close($zapr);

        return $response;
    }


    /**
     * get balance
     * @return mixed
     */
    public function getWalletBalance() : string
    {

        $res = $this->sendQueryPost('/api/wallet-balance/');

        $result =  json_decode($res, true);

        return $result["data"]["total"]["balance"];
    }

    /**
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getCurrencies(): ?array
    {

        $res = $this->sendQueryPost('/api/currencies/');

        return json_decode($res, true);
    }

}