<?php namespace App\Repositories\Admin;

use App\Core\EloquentRepository;

/**
 * Admin Vk Api Repository
 *  
 * @package   Repositories
 * @author    Den
 */
class AdminVkApiRepository extends EloquentRepository {

    public $apiKey;
    public $appId;
    public $login;
    public $password;
    public $authRedirectUrl;
    public $apiUrl = 'https://api.vk.com/method/';
    public $v = '2.0';
    public $urlc = '2';
    private $_sid;

    public function __construct($options) {

        foreach ($options as $key => $value) {
            $this->{$key} = $value;
        }
    }

    public function get($method, $params = false) {

        if (!$params) {
            $params = array();
        }

        $params['format'] = 'json';
        $url = $this->apiUrl . $method;
        ksort($params);
        $sig = '';

        foreach ($params as $k => $v) {
            $sig .= $k . '=' . $v;
        }

        $sig .= $this->apiKey;
        $params['sig'] = md5($sig);
        $query = $url . '?' . $this->_params($params);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_URL, $query);
        curl_setopt($ch, CURLOPT_REFERER, $query);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322)");
        $res = curl_exec($ch);
        curl_close($ch);

        return json_decode($res, true);
    }

    private function _params($params) {
        $pice = array();
        foreach ($params as $k => $v) {
            $pice[] = $k . '=' . urlencode($v);
        }
        return implode('&', $pice);
    }

    private function _responce($request) {

        if (isset($request['response'])) {
            return $request['response'];
        } else if (isset($request['error'])) {


            if ($request['error']['error_code'] == 14) {
                $captchaUrl = $request['error']['captcha_img'];
                $this->urlc = $captchaUrl;
                $captchaSid = $request['error']['captcha_sid'];
            }

            if ($request['error']['error_msg']) {
                $thUrl = $_SERVER['SCRIPT_NAME'];
                if ((($request['error']['error_msg'] == 'User authorization failed: invalid access_token.'))
                        OR ( ($request['error']['error_msg'] == 'User authorization failed: no access_token passed.'))) {
                    file_put_contents($this->cookieFileName, '');
                } elseif (($request['error']['error_msg'] == 'Captcha needed')) {
                    $thUrl = $_SERVER['SCRIPT_NAME'];
                    $captchaUrl = $request['error']['captcha_img'];
                    $this->urlc = $captchaUrl;
                    $captchaSid = $request['error']['captcha_sid'];
                } elseif (($request['error']['error_msg'] == 'Flood control')) {
                    
                }
            }
            return $request['error'];
        }
        return null;
    }

    public function photosGet($ownerId, $albumId, $rev, $extended, $offset, $count) {
        $request = $this->get('photos.get', array(
            'owner_id' => $ownerId,
            'album_id' => $albumId,
            'rev' => $rev,
            'extended' => $extended,
            'offset' => $offset,
            'count' => $count
        ));
        return $this->_responce($request);
    }

    public function getAlboms($ownerId) {
        $request = $this->get('photos.getAlbums', array(
            'owner_id' => $ownerId,
            'need_covers' => '1',
            'photo_sizes' => '1',
        ));
        return $this->_responce($request);
    }

    public function getAlbomsWithCaptcha($ownerId, $captchaSid, $captchaKey) {
        $request = $this->get('photos.getAlbums', array(
            'owner_id' => $ownerId,
            'need_covers' => '1',
            'photo_sizes' => '1',
            'captcha_sid' => $captchaSid,
            'captcha_key' => $captchaKey
        ));
        return $this->_responce($request);
    }

    public function photosGetWithCaptcha($ownerId, $albumId, $offset, $count, $captchaSid, $captchaKey) {
        $request = $this->get('photos.get', array(
            'owner_id' => $ownerId,
            'album_id' => $albumId,
            'rev' => '1',
            'extended' => '1',
            'offset' => $offset,
            'count' => $count,
            'captcha_sid' => $captchaSid,
            'captcha_key' => $captchaKey
        ));

        return $this->_responce($request);
    }

}
