<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
//        $em = $this->getDoctrine()->getRepository('AppBundle:Exchange')->findAll();
//        foreach ($em as $item){
//            var_dump($item->getName());
//        }
//        exit;
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ));
    }

    /**
     * @Route("/api/bitstamp",name="bitstamp")
     */
    public function bitstamp(Request $request){
        $pairs = array('BTCUSD'=>'btcusd', 'BTCEUR'=>'btceur','EURUSD'=>'eurusd',
            'BCHUSD'=>'bchusd','BCHEUR'=>'bcheur','BCHBTC'=>'bchbtc',
            'ETHUSD'=>'ethusd','ETHEUR'=>'etheur','ETHBTC'=>'ethbtc',
            'LTCUSD'=>'ltcusd','LTCEUR'=>'ltceur','LTCBTC'=>'ltcbtc',
            'XRPUSD'=>'xrpusd','XRPEUR'=>'erpeur','XRPBTC'=>'xrpbtc');
        $response = array();
        foreach ($pairs as $key => $pair){
            $response[$key] = (float)$this->curl("https://www.bitstamp.net/api/v2/ticker/".$pair."/")['last'];
        }

        return new JsonResponse($response);

    }

    /**
     * @Route("/api/bitbay",name="bitbay")
     */
    public function bitbay(Request $request){
        $pairs = array('BTCUSD'=>'BTC/USD','ETHUSD'=>'ETH/USD','LTCUSD'=>'LTC/USD');
        $response = array();
        foreach ($pairs as $key => $pair){
            $response[$key] = (float)$this->curl("https://bitbay.net/API/Public/".$pair."/ticker.json")['last'];
        }

        return new JsonResponse($response);

    }

    /**
     * @Route("/api/kraken",name="kraken")
     */
    public function kraken(Request $request){
        $pairs = array('BTCUSD'=>'XXBTZUSD','BTCEUR'=>'XXBTZEUR',
            'BCHUSD'=>'BCHUSD','BCHEUR'=>'BCHEUR','BCHBTC'=>'BCHXBT',
            'ETHUSD'=>'XETHZUSD','ETHEUR'=>'XETHZEUR','ETHBTC'=>'XETHXXBT',
            'DSHUSD'=>'DASHUSD','DSHEUR'=>'DASHEUR','DSHBTC'=>'DASHXBT',
            'EOSETH'=>'EOSETH','EOSBTC'=>'EOSXBT',
            'ETCUSD'=>'XETCZUSD','ETCETH'=>'XETCXETH','ETCBTC'=>'XETCXXBT',
            'LTCUSD'=>'XLTCZUSD','LTCEUR'=>'XLTCZEUR','LTCBTC'=>'XLTCXXBT',
            'XMRUSD'=>'XXMRZUSD','XMREUR'=>'XXMRZEUR','XMRXBT'=>'XXMRXXBT',
            'XRPUSD'=>'XXRPZUSD','XRPEUR'=>'XXRPZEUR','XRPXBT'=>'XXRPXXBT',
            'ZECUSD'=>'XZECZUSD','ZECEUR'=>'XZECZEUR','ZECXBT'=>'XZECXXBT',
        );
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
        $pairs = array('BCHUSD'=>'BCH-USD',
            'BTCEUR'=>'BTC-EUR','BTCUSD'=>'BTC-USD',
            'ETHBTC'=>'ETH-BTC','ETHEUR'=>'ETH-EUR','ETHUSD'=>'ETH-USD',
            'LTCBTC'=>'LTC-BTC','LTCEUR'=>'LTC-EUR','LTCUSD'=>'LTC-USD',
        );
        $response = array();
        foreach ($pairs as $key=>$pair){
//            var_dump($this->curl("https://api.gdax.com/products/".$pair."/ticker"));
//            exit;
            $response[$key] = $this->curl("https://api.gdax.com/products/".$pair."/ticker")['price'];
        }

        return new JsonResponse($response);
    }

    /**
     * @Route("/api/poloniex",name="poloniex")
     */
    public function poloniex(Request $request){
        $pairs = array('BTCUSDT'=>'USDT_BTC',
            'BCHUSDT'=>'USDT_BCH',
            'ETHUSDT'=>'USDT_ETH',
            'DSHUSDT'=>'USDT_DASH',
            'ETCUSDT'=>'USDT_ETC',
            'LTCUSDT'=>'USDT_LTC','LTCBTC'=>'BTC_LTC',
            'XMRUSDT'=>'USDT_XMR',
            'ZECUSDT'=>'USDT_ZEC',
            'BTCDOGE'=>'BTC_DOGE','XRPBTC'=>'BTC_XRP',
            'XMRBTC'=>'BTC_XMR','DSHBTC'=>'BTC_DASH','ETCETH'=>'ETH_ETC','ETHBTC'=>'BTC_ETH',
            'BCHETH'=>'ETH_BCH','BCHBTC'=>'BTC_BCH'
            );
        $return = $this->curl("https://poloniex.com/public?command=returnTicker");
        $response = array();
        foreach ($pairs as $key =>$pair){
            $response[$key] = (float)$return[$pair]['last'];
        }
        return new JsonResponse($response);
    }

    /**
     * @Route("/api/bitfinix",name="bitfinex")
     */
    public function bitfinix(Request $request){
        $pairs = array('BTCUSD'=>'btcusd','BTCEUR'=>'btceur',
            'ETHUSD'=>'ethusd','ETHBTC'=>'ethbtc',
//            'ZECUSD'=>'zecusd','ZECBTC'=>'zecbtc',
//            'BTGUSD'=>'btgusd','BTGBTC'=>'btgbtc',
//            'DSHUSD'=>'dshusd','DSHBTC'=>'dshbtc',
//            'ETCUSD'=>'etcusd','ETCBTC'=>'etcbtc',
//            'LTCUSD'=>'ltcusd','LTCBTC'=>'ltcbtc',
//            'XMRUSD'=>'xmrusd','XMRBTC'=>'xmrbtc',
//            'XRPUSD'=>'xrpusd','XRPBTC'=>'xrpbtc',
//            'IOTETH'=>'iotaeth','IOTBTC'=>'iotabtc',
//            'EOSUSD'=>'eosusd','EOSBTC'=>'eosbtc','EOSETH'=>'eoseth',
//            'BCHUSD'=>'bchusd','BCHBTC'=>'bchbtc','BCHETH'=>'bcheth',

        );
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
        $pairs = array('BTCUSD'=>'USDT-BTC','ETHUSD'=>'USDT-ETH','BTGUSD'=>'USDT-BTG','LTCUSD'=>'USDT-LTC','XMRUSD'=>'USDT-XMR','XRPUSD'=>'USDT-XRP');
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
                $response['BTCUSD'] = (float)$row['lprice'];
            }elseif ($row['symbol1']=='BCH'){
                $response['BCHUSD'] = (float)$row['lprice'];
            }elseif ($row['symbol1']=='ETH'){
                $response['ETHUSD'] = (float)$row['lprice'];
            }elseif ($row['symbol1']=='BTG'){
                $response['BTGUSD'] = (float)$row['lprice'];
            }elseif ($row['symbol1']=='DASH'){
                $response['DSHUSD'] = (float)$row['lprice'];
            }elseif ($row['symbol1']=='XRP'){
                $response['XRPUSD'] = (float)$row['lprice'];
            }elseif ($row['symbol1']=='ZEC'){
                $response['ZECUSD'] = (float)$row['lprice'];
            }
        }

        foreach ($this->curl("https://cex.io/api/last_prices/EUR")['data'] as $row){
            if($row['symbol1']=='BTC'){
                $response['BTCEUR'] = (float)$row['lprice'];
            }elseif ($row['symbol1']=='BCH'){
                $response['BCHEUR'] = (float)$row['lprice'];
            }elseif ($row['symbol1']=='ETH'){
                $response['ETHEUR'] = (float)$row['lprice'];
            }elseif ($row['symbol1']=='BTG'){
                $response['BTGEUR'] = (float)$row['lprice'];
            }elseif ($row['symbol1']=='DASH'){
                $response['DSHEUR'] = (float)$row['lprice'];
            }elseif ($row['symbol1']=='XRP'){
                $response['XRPEUR'] = (float)$row['lprice'];
            }elseif ($row['symbol1']=='ZEC'){
                $response['ZECEUR'] = (float)$row['lprice'];
            }
        }

        foreach ($this->curl("https://cex.io/api/last_prices/BTC")['data'] as $row){
            if ($row['symbol1']=='BCH'){
                $response['BCHBTC'] = (float)$row['lprice'];
            }elseif ($row['symbol1']=='ETH'){
                $response['ETHBTC'] = (float)$row['lprice'];
            }elseif ($row['symbol1']=='BTG'){
                $response['BTGBTC'] = (float)$row['lprice'];
            }elseif ($row['symbol1']=='DASH'){
                $response['DSHBTC'] = (float)$row['lprice'];
            }elseif ($row['symbol1']=='XRP'){
                $response['XRPBTC'] = (float)$row['lprice'];
            }elseif ($row['symbol1']=='ZEC'){
                $response['ZECBTC'] = (float)$row['lprice'];
            }
        }

        return new JsonResponse($response);
    }

    /**
     * @Route("/api/gemini",name="gemini")
     */
    public function gemini(Request $request){
        $pairs = array('BTCUSD'=>'btcusd',
            'ETHUSD'=> 'ethusd','ETHBTC'=> 'ethbtc',
            );
        $response = array();
        foreach ($pairs as $key=>$pair){
            $response[$key] = $this->curl("https://api.gemini.com/v1/pubticker/".$pair)['last'];
        }
        return new JsonResponse($response);
    }

    /**
     * @Route("/api/exmo",name="exmo")
     */
    public function exmo(Request $request){
        $return = $this->curl("https://api.exmo.com/v1/ticker/");
        $response = array();
        $response['BTCUSD'] = (float)$return['BTC_USD']['sell_price'];
        $response['BTCEUR'] = (float)$return['BTC_EUR']['sell_price'];
        $response['BTCUSDT'] = (float)$return['BTC_USDT']['sell_price'];
        $response['BCHUSD'] = (float)$return['BCH_USD']['sell_price'];
        $response['BCHBTC'] = (float)$return['BCH_BTC']['sell_price'];
        $response['BCHETH'] = (float)$return['BCH_ETH']['sell_price'];
        $response['ETHUSD'] = (float)$return['ETH_USD']['sell_price'];
        $response['ETHLTC'] = (float)$return['ETH_LTC']['sell_price'];
        $response['ETHEUR'] = (float)$return['ETH_EUR']['sell_price'];
        $response['ETHUSDT'] = (float)$return['ETH_USDT']['sell_price'];
        $response['DSHUSD'] = (float)$return['DASH_USD']['sell_price'];
        $response['DSHBTC'] = (float)$return['DASH_BTC']['sell_price'];
        $response['ETCUSD'] = (float)$return['ETC_USD']['sell_price'];
        $response['ETCBTC'] = (float)$return['ETC_BTC']['sell_price'];
        $response['LTCEUR'] = (float)$return['LTC_EUR']['sell_price'];
        $response['LTCBTC'] = (float)$return['LTC_BTC']['sell_price'];
        $response['LTCUSD'] = (float)$return['LTC_USD']['sell_price'];
        $response['USDTUSD'] = (float)$return['USDT_USD']['sell_price'];
        $response['XMRUSD'] = (float)$return['XMR_USD']['sell_price'];
        $response['XMREUR'] = (float)$return['XMR_EUR']['sell_price'];
        $response['XMRBTC'] = (float)$return['XMR_BTC']['sell_price'];
        $response['XRPUSD'] = (float)$return['XRP_USD']['sell_price'];
        $response['XRPBTC'] = (float)$return['XRP_BTC']['sell_price'];
        $response['ZECUSD'] = (float)$return['ZEC_USD']['sell_price'];
        $response['ZECEUR'] = (float)$return['ZEC_EUR']['sell_price'];
        $response['ZECBTC'] = (float)$return['ZEC_BTC']['sell_price'];
        $response['DOGEBTC'] = (float)$return['DOGE_BTC']['sell_price'];

        return new JsonResponse($response);
    }

    /**
     * @Route("/api/bitpay",name="bitpay")
     */
    public function bitpay(Request $request){
        $response = array();
        $return = $this->curl("https://bitpay.com/api/rates/");
        foreach ($return as $pair){
            if($pair['code']=='USD'){
                $response['BTCUSD'] = $pair['rate'];
            }
        }


        return new JsonResponse($response);
    }

    /**
     * @Route("/api/binance",name="binance")
     */
    public function binance(Request $request){
        $pairs = array('BTCUSDT'=>'BTCUSDT',
            'ETHBTC'=>'ETHBTC','ETHUSDT'=>'ETHUSDT',
            'LTCBTC'=>'LTCBTC',
            'EOSETH'=>'EOSETH','EOSBTC'=>'EOSBTC',
            'ETHETH'=>'ETCETH','ETCBTC'=>'ETCBTC',
            'ZECETH'=>'ZECETH','ZECBTC'=>'ZECBTC',
            'DSHETH'=>'DASHETH','DSHBTC'=>'DASHBTC',
            'BTGBTC'=>'BTGBTC',
            'XRPBTC'=>'XRPBTC',
            'ADABTC'=>'ADABTC',
            'XMRETH'=>'XMRETH','XMRBTC'=>'XMRBTC',
            'LTCETH'=>'LTCETH','LTCUSDT'=>'LTCUSDT',
            'IOTBTC'=>'IOTABTC','IOTETH'=>'IOTAETH',

            );
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
        $pairs = array('DSHBTC'=>'dash_btc','ETHBTC'=>'eth_btc','LTCETH'=>'ltc_eth','DSHETH'=>'dash_eth',
            'LTCUSDT'=>'ltc_usdt','BTCUSDT'=>'btc_usdt','DSHUSDT'=>'dash_usdt',
            'ETHUSDT'=>'eth_usdt','EOSBTC'=>'eos_btc','EOSETH'=>'eos_eth','EOSUSDT'=>'eos_usdt',
            'LTCBTC'=>'ltc_btc'
            );
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
        $pairs = array('BTCUSD'=>'BTCUSD',
            'BCHUSD'=>'BCHUSD','BCHBTC'=>'BCHBTC','BCHETH'=>'BCHETH',
            'ETCBTC'=>'ETCBTC','ETCUSD'=>'ETCUSD','ETCETH'=>'ETCETH',
            'ETHUSD'=>'ETHUSD','ETHBTC'=>'ETHBTC',
            'BNTUSD'=>'BNTUSD',
            'XRPBTC'=>'XRPBTC',
            'EOSETH'=>'EOSETH','EOSBTC'=>'EOSBTC','EOSUSD'=>'EOSUSD',
            'BTGUSD'=>'BTGUSD',
            'DSHUSD'=>'DASHUSD','DSHBTC'=>'DASHBTC','DSHETH'=>'DASHETH',
            'LTCUSD'=>'LTCUSD','LTCBTC'=>'LTCBTC',
            'XMRUSD'=>'XMRUSD','XMRBTC'=>'XMRBTC','XMRETH'=>'XMRETH',
            'ZECUSD'=>'ZECUSD','ZECBTC'=>'ZECBTC','ZECETH'=>'ZECETH',
            'DOGEBTC'=>'DOGEBTC','DOGEUSD'=>'DOGEUSD',
    );
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
        $pairs = array('BTCUSD'=>'BTC/USD','BTCEUR'=>'BTC/EUR',
                        'BCHUSD'=>'BCH/USD','BCHBTC'=>'BCH/BTC','BCHETH'=>'BCH/ETH',
                        'EOSUSD'=>'EOS/USD','EOSBTC'=>'EOS/BTC','EOSETH'=>'EOS/ETH',
                        'ETHUSD'=>'ETH/USD','ETHBTC'=>'ETH/BTC',
                        'LTCUSD'=>'LTC/USD','LTCBTC'=>'LTC/BTC',
                        'DSHUSD'=>'DASH/USD','DSHBTC'=>'DASH/BTC',
                        'DOGEUSD'=>'DOGE/USD','DOGEBTC'=>'DOGE/BTC',
                        'XMRUSD'=>'XMR/USD','XMRBTC'=>'XMR/BTC');
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
        $pairs = array('BTCUSD'=>'btc_usd','BTCEUR'=>'btc_eur',
            'BCHUSD'=>'bch_usd','BCHBTC'=>'bch_btc','BCHEUR'=>'bch_eur','BCHETH'=>'bch_eth',
            'ETHUSD'=>'eth_usd','ETHBTC'=>'eth_btc','ETHEUR'=>'eth_eur','ETHLTC'=>'eth_ltc',
            'DSHUSD'=>'dsh_usd','DSHBTC'=>'dsh_btc','DSHEUR'=>'dsh_eur','DSHETH'=>'dsh_eth',
            'LTCUSD'=>'ltc_usd','LTCBTC'=>'ltc_btc','LTCEUR'=>'ltc_eur',
            'ZECUSD'=>'zec_usd','ZECBTC'=>'zec_btc',

        );
        $parameter = implode("-",$pairs);
        $response = array();
        $return = $this->curl("https://wex.nz/api/3/ticker/".$parameter);
        foreach ($pairs as $key=>$pair) {
            $response[$key] = (float)$return[$pair]['last'];
        }
        return new JsonResponse($response);
    }

    /**
     * @Route("/api/gate",name="gate")
     */
    public function gate(Request $request){
        $pairs = array('BTCUSDT'=>'btc_usdt',
            'BCHUSDT'=>'bch_usdt','BCHBTC'=>'bch_btc',
            'ETHUSDT'=>'eth_usdt','ETHBTC'=>'eth_btc',
            'ETCUSDT'=>'etc_usdt','ETCBTC'=>'etc_btc','ETCETH'=>'etc_eth',
            'LTCUSDT'=>'ltc_usdt','LTCBTC'=>'ltc_btc',
            'DSHUSDT'=>'dash_usdt','DSHBTC'=>'dash_btc',
            'ZECUSDT'=>'zec_usdt',
            'EOSUSDT'=>'eos_usdt','EOSETH'=>'eos_eth','EOSBTC'=>'eos_btc',
            'XMRUSDT'=>'xmr_usdt','XMRBTC'=>'xmr_btc',
            'XRPUSDT'=>'xrp_usdt','XRPBTC'=>'xrp_btc',
            'DOGEUSDT'=>'doge_usdt','DOGEBTC'=>'doge_btc',
            'ADABTC'=>'ada_btc',
            'IOTBTC'=>'iota_btc',
            'ZECBTC'=>'zec_btc',
            'BTGBTC'=>'btg_btc',

        );
        $response = array();
        $return = $this->curl("http://data.gate.io/api2/1/tickers");
        foreach ($pairs as $key=>$pair) {
            $response[$key] = (float)$return[$pair]['last'];
        }
        return new JsonResponse($response);
    }

    /**
     * @Route("/api/coinsBank",name="coninsBank")
     */
    public function coinsBank(Request $request){
        $pairs = array('BTCEUR'=>'BTCEUR',
                'LTCEUR'=>'LTCEUR','LTCUSD'=>'LTCUSD','LTCBTC'=>'LTCBTC',
        );

        $response = array();
        $return = $this->curl("https://coinsbank.com/api/bitcoincharts/ticker/");
        foreach ($return as $price){
            foreach ($pairs as $key=>$pair){
                if($price['name'] == $pair){
                    $response[$key] = (float)$price['last'];
                }

            }

        }
        return new JsonResponse($response);
    }

    /**
     * @Route("/api/xbtce",name="xbtce")
     */
    public function xbtce(Request $request){
        $pairs = array('BTCUSD'=>'BTCUSD','BCHUSD'=>'BCHUSD','ETHUSD'=>'ETHUSD','DSHUSD'=>'DSHUSD','LTCUSD'=>'LTCUSD');
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
     * @Route("/api/bitflyerLightning",name="bitflyerLightning")
     */
    public function bitflyerLightning(Request $request){
        $pairs = array('ETHBTC'=>'ETH_BTC','BCHBTC'=>'BCH_BTC',

        );
        $response = array();
        foreach ($pairs as $key => $pair){
            $response[$key] = (float)$this->curl("https://api.bitflyer.jp/v1/ticker?product_code=".$pair)['ltp'];
        }

        return new JsonResponse($response);
    }

    /**
     * @Route("/api/itbit",name="itbit")
     */
    public function itbit(Request $request){
        $pairs = array('BTCUSD'=>'XBTUSD','BTCEUR'=>'XBTEUR',);
        $response = array();
        foreach ($pairs as $key => $pair){
            $response[$key] = (float)$this->curl("https://api.itbit.com/v1/markets/".$pair."/ticker")['lastPrice'];
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
            CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:17.0) Gecko/20100101 Firefox/17.0',
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

    /**
     * @Route("/email", name="email")
     */
    public function emailSend(Request $request){
            $transport = (new \Swift_SmtpTransport('smtp.gmail.com', 465,'ssl'))
                ->setUsername('testcrypto8@gmail.com')
                ->setPassword('Crypto88')
            ;

            $mailer = new \Swift_Mailer($transport);
            $message = (new \Swift_Message('Crypto Alerts'))
                ->setFrom(['testcrypto8@gmail.com' => 'Crypto Alerts'])
                ->setTo('contact@thehouseofbitcoins.io')
                ->setBody($request->get('email'),
                    'text/html'
                )
            ;
            $result = $mailer->send($message);

            return new Response($result);
        }

}
