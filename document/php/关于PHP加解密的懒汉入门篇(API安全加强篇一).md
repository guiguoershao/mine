### 关于PHP加解密的懒汉入门篇(API安全加强篇一)

#### 懒汉 入门
* 不过这里还是要先说一点儿，就是很多泥腿子一直拿md5当加密算法来看待，但实际上md5是一种信息摘要算法（其实就是哈希），不是加密算法，因为md5不可逆，但是加解密是一个可逆的过程，所以以后这种低级错误还是不要犯的为好。

* 加密技术一直是技术圈中的一个独特领域和分支，其一些原理并不是随随便便就可以理解的来的。如果没有良好的数学底子，怕是很难研究下去。但是，作为一篇水文，不研究原理，仅仅来用一用来实践一把，还是没什么大问题的。

#### 加密分为两大类：

* 对称加密，常见算法有DES、3DES、AES等等，据说AES是比较屌的最新最常用的算法
* 非对称加密，RSA、DSA、ECDH等等
* 对称加密用粗话说就是用同一个密钥对信息加解密。比如元首要操作东线战场了，给古德里安发了一段电报，大概意思就是“你给我闪开，让我操作！立马南下打基辅！”，但是元首又怕朱可夫给看到这段消息，于是元首就用了一个强壮的密钥123456来加密这段话，然后这段话就变成akjdslfjalwjglajwg了。古德里安收到这坨乱七八糟的玩意后，用123456来解密一下，得到明文“你给我闪开，让我操作！立马南下打基辅！”，然而朱可夫由于抓破脑壳也想不到这个超级密钥123456，所以朱可夫注定一脸懵逼，最终导致基辅60万苏军被奸！但是这里面有一个问题就是元首是如何告诉古德里安私钥是123456的。

* 两个人提前就商量好了，1941年6月22日的前一天偷偷商量好了。。。
* 两个人不是提前商量好的，而是古德里安到东线后，元首通过打电话、发电报、QQ、微信。。。 。。。
* 对于朱可夫来说，如果对方采用了方案1，那么他也没啥好办法，只能等潜伏在古德里安身边的特工卧底返回123456。由于密钥被暴露了，所以必须换新的密钥，元首这会儿只能走途径2告诉古德里安新的密钥，这会儿逗逼的事情来了，如何对密钥进行加密。答案是不能，此时问题陷入到欲要加密，必先加密的矛盾中。所以，这个密钥是注定要通过明文传输了，只要是明文传输，朱可夫就一定有机会把密钥搞到手。



* 非对称加密就是解决这个难题而生。密钥换来换去还想不暴露，扯犊子。还是元首和古德里安，这会儿他俩分别生成一对自己的公钥和私钥。这里需要强调的是：

* 公钥和私钥是成双成对生成的，二者之间通过某种神秘的数学原理连接着，具体是啥，我也不知道
* 公钥加密的数据，只能通过相应的私钥解密；私钥加密的数据，只能通过对应的公钥解密
* 公钥可以颁发给任何人，然而私钥你自己偷偷摸摸藏到自己裤裆里，别弄丢了
* 这会儿就简单了，元首把自己公钥给古德里安，然后古德里安把自己公钥给元首，然后都偷偷摸摸保存好自己的私钥。有一天，元首告诉古德里安“你丫别干了，天天不听我操作！”，然后用古德里安颁发的公钥加密好了，然后让空军到东线直接仍传单，扔的满地都是，古德里安看到后从裤裆里拿出自己的私钥解密，然后就立马请假回家休息了，回去前用元首的公钥加密了如下消息“傻逼，老子还不伺候了！”，然后让空军回去撒了柏林一地，元首看到后从裤裆里拿出自己的私钥一解密：“卧槽。。。”。虽然这双方都是大大咧咧的发传单，但是朱可夫只能在旁边一脸懵逼、生无可恋。因为用于解密的私钥从来不会在外流通，所以，泄露的可能性是0。



* 但是，有一点是值得说明，那就是无论是对称加密还是非对称加密，都顶不住用机器是强行暴力猜解私钥。一年不行两年，两年不行二十年，二十年不行一百年，总是能猜出来的，这是没有办法的一件事情。大家可以搜一搜关于768bit RSA被KO的事件，是吧。

* 下面我们从gayhub上扒了一个对称加密的库下来，尝试一把aes对称加密算法，地址如下：

* https://github.com/ivantcholakov/gibberish-aes-php 直接git clone到目录中，然后测试代码如下：
```
<?php
require 'GibberishAES.php';
$pass   = '123456';
$string = '你好，古德里安，我是希特勒，你赶紧给我滚回来...';
GibberishAES::size(256);
$encrypted_string = GibberishAES::enc( $string, $pass );
$decrypted_string = GibberishAES::dec( $encrypted_string, $pass );
echo PHP_EOL."加密后的：".$encrypted_string.PHP_EOL;
echo "解密后的：".$decrypted_string.PHP_EOL.PHP_EOL;
//保存为test.php，运行一下结果如下：
```



```
// 然后我们将上面代码反复运行100,000次，看看耗费多长时间：

require 'GibberishAES.php';
$pass   = '123456';
$string = '你好，古德里安，我是希特勒，你赶紧给我滚回来...';
GibberishAES::size(256);
$start_time = microtime( true );
for( $i = 1; $i <= 100000; $i++ ) {
  $encrypted_string = GibberishAES::enc( $string, $pass );
  $decrypted_string = GibberishAES::dec( $encrypted_string, $pass );
}
$end_time = microtime( true );
echo "一共耗时：".( $end_time -  $start_time ).PHP_EOL;
//保存为test.php，运行一下结果如下：
```

```
// 然后，我们再去gayhub上扒一个非对称加密的library，比如这个：https://github.com/vlucas/pikirasa 我们把代码扒下来，然后自己写个demo试一下，如下：

<?php
$publicKey = '
-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA7o9A47JuO3wgZ/lbOIOs
Xc6cVSiCMsrglvORM/54StFRvcrxMi7OjXD6FX5fQpUOQYZfIOFZZMs6kmNXk8xO
hgTmdMJcBWolQ85acfAdWpTpCW29YMvXNARUDb8uJKAApsISnttyCnbvp7zYMdQm
HiTG/+bYaegSXzV3YN+Ej+ZcocubUpLp8Rpzz+xmXep3BrjBycAE9z2IrrV2rlwg
TTxU/B8xmvMsToBQpAbe+Cv130tEHsyW4UL9KZY1M9R+UHFPPmORjBKxSZvjJ1mS
UbUYN6PmMry35wCaFCfQoyTDUxBfxTGYqjaveQv4sxx0uvoiLXHt9cAm5Q8KJ+8d
FwIDAQAB
-----END PUBLIC KEY-----
';
$privateKey = '
-----BEGIN RSA PRIVATE KEY-----
MIIEpAIBAAKCAQEA7o9A47JuO3wgZ/lbOIOsXc6cVSiCMsrglvORM/54StFRvcrx
Mi7OjXD6FX5fQpUOQYZfIOFZZMs6kmNXk8xOhgTmdMJcBWolQ85acfAdWpTpCW29
YMvXNARUDb8uJKAApsISnttyCnbvp7zYMdQmHiTG/+bYaegSXzV3YN+Ej+Zcocub
UpLp8Rpzz+xmXep3BrjBycAE9z2IrrV2rlwgTTxU/B8xmvMsToBQpAbe+Cv130tE
HsyW4UL9KZY1M9R+UHFPPmORjBKxSZvjJ1mSUbUYN6PmMry35wCaFCfQoyTDUxBf
xTGYqjaveQv4sxx0uvoiLXHt9cAm5Q8KJ+8dFwIDAQABAoIBAHkWS3iHy/3zjjtY
TV4NL8NZqO5splGDuqXEMbKzenl3b8cnKHAxY/RVIQsh3tZb9CV8P/Lfj1Fi+nLt
a7mAXWcXO6aONMkmzI1zQ2NL3opoxTRc+GAWd0BW5hcoMBK1CD+ciHkLqAH5xsFc
UFxSc5qfTkb79GMlQZYD/Hk2WwHyj7hAkyxip4ye1EOnH5h8H7vIUjwp+H6Rmt5w
FTiVJbokhzwiczChUJVWgnowegL/qFV+yNfHGGKqVdIQfKdCsHR6jAuKCww5QniN
qDEi/M2Az0R4qfVmf38uMvOJTWaxp08JV4qRyNdh6hhbj+nY1EZ8haOiC7tjz2mJ
XqqKQfkCgYEA95yb5ezTBF4Pbr589OnU6VFdM88BCrKKvSWE8D1fzZZTsXur5k/x
cOwfio4RkmJwMnjuzZN6nvL5QddfcmPWQAoepHR8eA9yhIz57YWgrqE9ZXI8DgMy
SFuy5EkV5vudjDIr7kBXaGuUh3ErZfglyrV/rUfydGdTWyY8phMq/6MCgYEA9qQj
7kb5uyU8nrXoDqKPpy6ijEpVilgy4VR7RuB2vMh74wKI1QQYED+PxfcHe5RP8WGF
Bl+7VnmrGka4xJWeN7GKW4GRx5gRAzg139DXkqwPlXyM3ZR3pLd8wtbxTmJrcPby
A6uNRhGPpuyhDs5hx9z6HvLoCs+O0A9gDaChM/0CgYEAycRguNPpA2cOFkS8l+mu
p8y4MM5eX/Qq34QiNo0ccu8rFbXb1lmQOV7/OK0Znnn+SPKITRX+1mTRPZidWx4F
aLuWSpXtEvwrad1ijuzTiVk0KWUTkKuEHrgyJplzcnvX3nTHnWXqk9kN9+v83CN/
0BVji7TT2YyUvPKEeyOlZxcCgYABFm42Icf+JEblKEYyslLR2OnMlpNT/dmTlszI
XjsH0BaDxMIXtmHoyG7434L/74J+vQBaK9fmpLi1b/RmoYZGFplWl/atm6UPj5Ll
PsWElw+miBsS6xGv/0MklNARmWuB3wToMTx5P6CTit2W9CAIQpgzxLxzN8EYd8jj
pn6vfQKBgQCHkDnpoNZc2m1JksDiuiRjZORKMYz8he8seoUMPQ+iQze66XSRp5JL
oGZrU7JzCxuyoeA/4z36UN5WXmeS3bqh6SinrPQKt7rMkK1NQYcDUijPBMt0afO+
LH0HIC1HAtS6Wztd2Taoqwe5Xm75YW0elo4OEqiAfubAC85Ec4zfxw==
-----END RSA PRIVATE KEY-----
';
require 'RSA.php';
$rsa       = new RSA( $publicKey, $privateKey );
$data      = '你好，古德里安，我是希特勒，你赶紧给我滚回来...';
$encrypted = $rsa->encrypt( $data );
$decrypted = $rsa->decrypt( $encrypted );
echo "加密过后的：".$encrypted.PHP_EOL;
echo "解密过后的：".$decrypted.PHP_EOL;
// 保存为test.php运行一下，如下图所示：



// 然后我们将上面代码反复运行100,000次，看看耗费多长时间，这里只贴关键部分代码：

<?php
require 'RSA.php';
$rsa       = new RSA( $publicKey, $privateKey );
$data      = '你好，古德里安，我是希特勒，你赶紧给我滚回来...';
$start = microtime( true );
for( $i = 1; $i <= 100000; $i++ ) {
  $encrypted = $rsa->encrypt( $data );
  $decrypted = $rsa->decrypt( $encrypted );
}
$end = microtime( true );
echo "一共耗时：".( $end - $start ).PHP_EOL;

// 然后，运行结果如下图所示（实际上由于等待时间太长了，我索性去刷牙洗脸了）：
```

* 转载来源　https://segmentfault.com/a/1190000018977184