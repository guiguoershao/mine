<?php


namespace Library\Mcrypt;


class Rsa extends BaseMcrypt
{
    private $publicKey = '';
    private $privateKey = '';
    const PRIVATE_KEY_ENCODE = 1; // 私钥加密
    const PUBLIC_KEY_DECODE = 2; // 公钥解密
    const PUBLIC_KEY_ENCODE = 2; // 公钥加密
    const PRIVATE_KEY_DECODE = 1; // 私钥解密

    /**
     * Rsa constructor.
     * @param string $publicKey
     * @param string $privateKey
     */
    public function __construct($publicKey = '', $privateKey = '')
    {
        $this->publicKey = $publicKey;
        $this->privateKey = $privateKey;
    }

    /**
     * 加密
     * @param $input
     * @param Integer $type
     * @return string
     * @throws McryptException
     */
    public function encrypt($input, $type)
    {
        return $this->privateKeyEncode($input, $type);
    }

    /**
     * 解密
     * @param $input
     * @param $type
     * @return bool|string
     * @throws McryptException
     */
    public function decrypt($input, $type)
    {
        return $this->decodePrivateEncode($input, $type);
    }

    /**
     * 加密
     * @param $input
     * @param $type
     * @return string
     * @throws McryptException
     */
    private function privateKeyEncode($input, $type)
    {
        $encodeKey = $this->_getKey($type);

        $data = $this->_splitEncode($input); // 把要加密地信息 base64_encode 后等长放入数组

        $encrypted = '';
        $encryptedData = [];
        // //理论上是可以只加密数组中的第一个元素 其他的不加密 因为只要一个解密不出来 整体也就解密不出来 这里先全部加密
        foreach ($data as $key => $value) {
            if ($type === self::PRIVATE_KEY_ENCODE) {
                openssl_private_encrypt($value, $encrypted, $encodeKey);
            } else {
                openssl_public_encrypt($value, $encrypted, $encodeKey);
            }
            $encryptedData[$key] = $encrypted;
        }
        return $this->_toString($encryptedData); //序列化后 base64_encode
    }

    /**
     * 解密
     * @param $input
     * @param $type
     * @return bool|string
     * @throws McryptException
     */
    private function decodePrivateEncode($input, $type)
    {
        $decodeKey = $this->_getKey($type);
        $data = $this->_toArray($input);
        $decrypted = '';
        $string = '';
        foreach ($data as $key => $value) {
            if ($type === self::PUBLIC_KEY_DECODE) {
                openssl_public_decrypt($value, $encrypted, $decodeKey);
            } else {
                openssl_private_decrypt($value, $encrypted, $decodeKey);
            }
            $string .= $decrypted;
        }
        return base64_decode($string);
    }

    /**
     * 检查是否 含有所需配置文件
     * @param $type
     * @return int
     * @throws McryptException
     */
    private function _getKey($type)
    {
        dump($type);
        switch ($type) {
            case 1:
                if (empty($this->privateKey)) {
                    throw new McryptException("请配置私钥");
                }
                return openssl_pkey_get_private($this->privateKey);
            case 2:
                if (empty($this->publicKey)) {
                    throw new McryptException("请配置公钥");
                }
                return openssl_pkey_get_public($this->publicKey);
        }
        throw new McryptException("请先配置公钥和私钥");
    }

    /**
     * 把要加密地信息 base64_encode后等长放入数组
     * @param $data
     * @return array
     */
    private function _splitEncode($data)
    {
        $data = base64_encode($data); // 加base64 encode 便于用于分组
        $totalLen = strlen($data);
        $per = 96; // 能整除 2和3 Rsa每次加密不超过100个
        $dy = $totalLen % $per;
        $totalBlock = $dy ? ($totalLen / $per) : ($totalLen / $per - 1);
        $totalBlock = intval($totalBlock + 1);
        $return = [];
        for ($i = 0; $i < $totalBlock; $i++) {
            $return[] = substr($data, $i * $per, $per);
        }
        return $return;
    }

    /**
     * @param $data
     * @return string
     */
    private function _toString($data)
    {
        return base64_encode(serialize($data));
    }

    /**
     * @param $data
     * @return mixed
     * @throws McryptException
     */
    private function _toArray($data)
    {
        $data = unserialize(base64_decode($data));
        if (!is_array($data)) {
            throw new McryptException("数据加密不符合格式");
        }
        return $data;
    }

}