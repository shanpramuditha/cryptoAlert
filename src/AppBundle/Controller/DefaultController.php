<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ));
    }

    /**
     * @Route("/api/bitstamp",name="bitstamp")
     */
    public function bitstamp(Request $request){
        $pairs = array('BTC'=>'btcusd','BCH'=>'bchusd','ETH'=>'ethusd');
        $response = array();
        foreach ($pairs as $key => $pair){
            $response[$key] = (float)$this->curl("https://www.bitstamp.net/api/v2/ticker/".$pair."/")['last'];
        }

        return new JsonResponse($response);

    }

    /**
     * @Route("/api/kraken",name="kraken")
     */
    public function kraken(Request $request){
        $pairs = array('BTC'=>'XXBTZUSD','BCH'=>'BCHUSD','ETH'=>'XETHZUSD');
        $parameter = 'pair='.implode(",",$pairs);
        $response = array();
        $return = $this->curl("https://api.kraken.com/0/public/Ticker?".$parameter)['result'];
        foreach ($pairs as $key=>$pair) {
            $response[$key] = (float)$return[$pair]['c'][0];
        }

        return new JsonResponse($response);
    }

    /**
     * @Route("/api/gdax",name="gdax")
     */
    public function gdax(Request $request){
        $pairs = array('BCH-USD', 'LTC-EUR');
        $response = array();
        foreach ($pairs as $pair){
            $response = $this->curl("https://api.gdax.com/products/".$pair."/ticker");
        }

        return new JsonResponse('done');
    }

    /**
     * @Route("/api/poloniex",name="poloniex")
     */
    public function poloniex(Request $request){
        $pairs = array('BTC'=>'USDT_BTC','BCH'=>'USDT_BCH','ETH'=>'USDT_ETH');
        $return = $this->curl("https://poloniex.com/public?command=returnTicker");
        $response = array();
        foreach ($pairs as $key =>$pair){
            $response[$key] = (float)$return[$pair]['last'];
        }
        return new JsonResponse($response);
    }

    /**
     * @Route("/api/bitfinex",name="bitfinex")
     */
    public function bitfinex(Request $request){
        $pairs = array('BTC'=>'btcusd','BCH'=>'bchusd','ETH'=>'ethusd');
        $response = array();
        foreach ($pairs as $key => $pair){
            $response[$key] = (float)$this->curl("https://api.bitfinex.com/v1/pubticker/".$pair)['last_price'];
        }

        return new JsonResponse($response);
    }

    /**
     * @Route("/api/bittrex",name="bittrex")
     */
    public function bittrex(Request $request){
        $pairs = array('BTC'=>'USDT-BTC','ETH'=>'USDT-ETH');
        $response = array();
        foreach ($pairs as $key=>$pair){
            $response[$key] = (float)$this->curl("https://bittrex.com/api/v1.1/public/getticker?market=".$pair)['result']['Last'];
        }

        return new JsonResponse($response);
    }

    /**
     * @Route("/api/cex",name="cex")
     */
    public function cex(Request $request){
//        $pairs = array('USD', 'BTC');
//        $parameter = 'pair='.implode("/",$pairs);
        $response = array();
        foreach ($this->curl("https://cex.io/api/last_prices/USD")['data'] as $row){
            if($row['symbol1']=='BTC'){
                $response['BTC'] = (float)$row['lprice'];
            }elseif ($row['symbol1']=='BCH'){
                $response['BCH'] = (float)$row['lprice'];
            }elseif ($row['symbol1']=='ETH'){
                $response['ETH'] = (float)$row['lprice'];
            }
        }

        return new JsonResponse($response);
    }

    /**
     * @Route("/api/gemini",name="gemini")
     */
    public function gemini(Request $request){
        $pairs = array('btcusd', 'ethbtc','ethusd');
        $response = array();
        foreach ($pairs as $pair){
            $response = $this->curl("https://api.gemini.com/v1/pubticker/".$pair);
        }

        return new JsonResponse('done');
    }

    /**
     * @Route("/api/exmo",name="exmo")
     */
    public function exmo(Request $request){
        $return = $this->curl("https://api.exmo.com/v1/ticker/");
        $response = array();
        $response['BTC'] = (float)$return['BTC_USD']['sell_price'];
        $response['BCH'] = (float)$return['BCH_USD']['sell_price'];
        $response['ETH'] = (float)$return['ETH_USD']['sell_price'];

        return new JsonResponse($response);
    }

    /**
     * @Route("/api/bitpay",name="bitpay")
     */
    public function bitpay(Request $request){
        $response = array();
        $return = $this->curl("https://bitpay.com/api/rates/");
        $response['BTC'] = $return[1]['rate'];

        return new JsonResponse($response);
    }

    /**
     * @Route("/api/binance",name="binance")
     */
    public function binance(Request $request){
        $pairs = array('BTC'=>'BTCUSDT','ETH'=>'ETHUSDT');
        $response = array();
        $return = $this->curl("https://api.binance.com/api/v1/ticker/allPrices");
        foreach ($return as $price){
            foreach ($pairs as $key=>$pair){
                if($price['symbol'] == $pair){
                    $response[$key] = (float)$price['price'];
                }

            }

        }
        return new JsonResponse($response);
    }

    /**
     * @Route("/api/liqui",name="liqui")
     */
    public function liqui(Request $request){
        $pairs = array();
        $parameter = implode("-",$pairs);
        $response = array();
        $return = $this->curl("https://api.liqui.io/api/3/ticker/".$parameter);
        foreach ($pairs as $key=>$pair) {
            $response[$key] = (float)$return[$pair]['last'];
        }
        return new JsonResponse($response);
    }

    /**
     * @Route("/api/hitbtc",name="hitbtc")
     */
    public function hitbtc(Request $request){
        $pairs = array('BTC'=>'BTCUSD','BCH'=>'BCHUSD','ETH'=>'ETHUSD');
        $response = array();
        $return = $this->curl("https://api.hitbtc.com/api/2/public/ticker");
        foreach ($return as $price){
            foreach ($pairs as $key=>$pair){
                if($price['symbol'] == $pair){
                    $response[$key] = (float)$price['last'];
                }

            }

        }
        return new JsonResponse($response);
    }

    /**
     * @Route("/api/livecoin",name="livecoin")
     */
    public function livecoin(Request $request){
        $pairs = array('BTC'=>'BTC/USD','BCH'=>'BCH/USD','ETH'=>'ETH/USD');
        $response = array();
        $return = $this->curl("https://api.livecoin.net/exchange/ticker");
        foreach ($return as $price){
            foreach ($pairs as $key=>$pair){
                if($price['symbol'] == $pair){
                    $response[$key] = (float)$price['last'];
                }

            }

        }
        return new JsonResponse($response);
    }

    /**
     * @Route("/api/wex",name="wex")
     */
    public function wex(Request $request){
        $pairs = array('BTC'=>'btc_usd','BCH'=>'bch_usd','ETH'=>'eth_usd');
        $parameter = implode("-",$pairs);
        $response = array();
        $return = $this->curl("https://wex.nz/api/3/ticker/".$parameter);
        foreach ($pairs as $key=>$pair) {
            $response[$key] = (float)$return[$pair]['last'];
        }
        return new JsonResponse($response);
    }

    /**
     * @Route("/api/xbtce",name="xbtce")
     */
    public function xbtce(Request $request){
        $pairs = array('BTC'=>'BTCUSD','BCH'=>'BCHUSD','ETH'=>'ETHUSD');
        $response = array();
        $return = $this->curl("https://cryptottlivewebapi.xbtce.net:8443/api/v1/public/ticker");
        foreach ($return as $price){
            foreach ($pairs as $key=>$pair){
                if($price['Symbol'] == $pair){
                    $response[$key] = (float)$price['LastBuyPrice'];
                }

            }

        }
        return new JsonResponse($response);
    }












    /**
     * @param $url
     * @return mixed
     */
    private function curl($url){
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            var_dump("cURL Error #:" . $err);
        } else {
            return json_decode($response,true);
        }
    }
}
