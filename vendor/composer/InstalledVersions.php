<?php











namespace Composer;

use Composer\Autoload\ClassLoader;
use Composer\Semver\VersionParser;






class InstalledVersions
{
private static $installed = array (
  'root' => 
  array (
    'pretty_version' => 'dev-master',
    'version' => 'dev-master',
    'aliases' => 
    array (
    ),
    'reference' => '17e753c7178e4beaf5f18a8a4eb12f7a787e94bf',
    'name' => 'laravel/laravel',
  ),
  'versions' => 
  array (
    'asm89/stack-cors' => 
    array (
      'pretty_version' => 'v2.1.1',
      'version' => '2.1.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '73e5b88775c64ccc0b84fb60836b30dc9d92ac4a',
    ),
    'barryvdh/laravel-dompdf' => 
    array (
      'pretty_version' => 'v2.0.1',
      'version' => '2.0.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '9843d2be423670fb434f4c978b3c0f4dd92c87a6',
    ),
    'brick/math' => 
    array (
      'pretty_version' => '0.11.0',
      'version' => '0.11.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '0ad82ce168c82ba30d1c01ec86116ab52f589478',
    ),
    'composer/semver' => 
    array (
      'pretty_version' => '3.4.0',
      'version' => '3.4.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '35e8d0af4486141bc745f23a29cc2091eb624a32',
    ),
    'cordoval/hamcrest-php' => 
    array (
      'replaced' => 
      array (
        0 => '*',
      ),
    ),
    'darryldecode/cart' => 
    array (
      'pretty_version' => '4.2.4',
      'version' => '4.2.4.0',
      'aliases' => 
      array (
      ),
      'reference' => '25e347f89aecb20e769e228f10e62fa3d770e75d',
    ),
    'davedevelopment/hamcrest-php' => 
    array (
      'replaced' => 
      array (
        0 => '*',
      ),
    ),
    'dflydev/dot-access-data' => 
    array (
      'pretty_version' => 'v3.0.2',
      'version' => '3.0.2.0',
      'aliases' => 
      array (
      ),
      'reference' => 'f41715465d65213d644d3141a6a93081be5d3549',
    ),
    'doctrine/inflector' => 
    array (
      'pretty_version' => '2.0.8',
      'version' => '2.0.8.0',
      'aliases' => 
      array (
      ),
      'reference' => 'f9301a5b2fb1216b2b08f02ba04dc45423db6bff',
    ),
    'doctrine/instantiator' => 
    array (
      'pretty_version' => '2.0.0',
      'version' => '2.0.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'c6222283fa3f4ac679f8b9ced9a4e23f163e80d0',
    ),
    'doctrine/lexer' => 
    array (
      'pretty_version' => '1.2.3',
      'version' => '1.2.3.0',
      'aliases' => 
      array (
      ),
      'reference' => 'c268e882d4dbdd85e36e4ad69e02dc284f89d229',
    ),
    'dompdf/dompdf' => 
    array (
      'pretty_version' => 'v2.0.3',
      'version' => '2.0.3.0',
      'aliases' => 
      array (
      ),
      'reference' => 'e8d2d5e37e8b0b30f0732a011295ab80680d7e85',
    ),
    'dragonmantank/cron-expression' => 
    array (
      'pretty_version' => 'v3.3.3',
      'version' => '3.3.3.0',
      'aliases' => 
      array (
      ),
      'reference' => 'adfb1f505deb6384dc8b39804c5065dd3c8c8c0a',
    ),
    'egulias/email-validator' => 
    array (
      'pretty_version' => '2.1.25',
      'version' => '2.1.25.0',
      'aliases' => 
      array (
      ),
      'reference' => '0dbf5d78455d4d6a41d186da50adc1122ec066f4',
    ),
    'ezyang/htmlpurifier' => 
    array (
      'pretty_version' => 'v4.16.0',
      'version' => '4.16.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '523407fb06eb9e5f3d59889b3978d5bfe94299c8',
    ),
    'facade/flare-client-php' => 
    array (
      'pretty_version' => '1.10.0',
      'version' => '1.10.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '213fa2c69e120bca4c51ba3e82ed1834ef3f41b8',
    ),
    'facade/ignition' => 
    array (
      'pretty_version' => '2.17.7',
      'version' => '2.17.7.0',
      'aliases' => 
      array (
      ),
      'reference' => 'b4f5955825bb4b74cba0f94001761c46335c33e9',
    ),
    'facade/ignition-contracts' => 
    array (
      'pretty_version' => '1.0.2',
      'version' => '1.0.2.0',
      'aliases' => 
      array (
      ),
      'reference' => '3c921a1cdba35b68a7f0ccffc6dffc1995b18267',
    ),
    'fakerphp/faker' => 
    array (
      'pretty_version' => 'v1.23.0',
      'version' => '1.23.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'e3daa170d00fde61ea7719ef47bb09bb8f1d9b01',
    ),
    'fideloper/proxy' => 
    array (
      'pretty_version' => '4.4.2',
      'version' => '4.4.2.0',
      'aliases' => 
      array (
      ),
      'reference' => 'a751f2bc86dd8e6cfef12dc0cbdada82f5a18750',
    ),
    'filp/whoops' => 
    array (
      'pretty_version' => '2.15.3',
      'version' => '2.15.3.0',
      'aliases' => 
      array (
      ),
      'reference' => 'c83e88a30524f9360b11f585f71e6b17313b7187',
    ),
    'fruitcake/laravel-cors' => 
    array (
      'pretty_version' => 'v2.2.0',
      'version' => '2.2.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '783a74f5e3431d7b9805be8afb60fd0a8f743534',
    ),
    'graham-campbell/result-type' => 
    array (
      'pretty_version' => 'v1.1.1',
      'version' => '1.1.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '672eff8cf1d6fe1ef09ca0f89c4b287d6a3eb831',
    ),
    'guzzlehttp/guzzle' => 
    array (
      'pretty_version' => '7.8.0',
      'version' => '7.8.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '1110f66a6530a40fe7aea0378fe608ee2b2248f9',
    ),
    'guzzlehttp/promises' => 
    array (
      'pretty_version' => '2.0.1',
      'version' => '2.0.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '111166291a0f8130081195ac4556a5587d7f1b5d',
    ),
    'guzzlehttp/psr7' => 
    array (
      'pretty_version' => '2.6.1',
      'version' => '2.6.1.0',
      'aliases' => 
      array (
      ),
      'reference' => 'be45764272e8873c72dbe3d2edcfdfcc3bc9f727',
    ),
    'hamcrest/hamcrest-php' => 
    array (
      'pretty_version' => 'v2.0.1',
      'version' => '2.0.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '8c3d0a3f6af734494ad8f6fbbee0ba92422859f3',
    ),
    'illuminate/auth' => 
    array (
      'replaced' => 
      array (
        0 => 'v8.83.27',
      ),
    ),
    'illuminate/broadcasting' => 
    array (
      'replaced' => 
      array (
        0 => 'v8.83.27',
      ),
    ),
    'illuminate/bus' => 
    array (
      'replaced' => 
      array (
        0 => 'v8.83.27',
      ),
    ),
    'illuminate/cache' => 
    array (
      'replaced' => 
      array (
        0 => 'v8.83.27',
      ),
    ),
    'illuminate/collections' => 
    array (
      'replaced' => 
      array (
        0 => 'v8.83.27',
      ),
    ),
    'illuminate/config' => 
    array (
      'replaced' => 
      array (
        0 => 'v8.83.27',
      ),
    ),
    'illuminate/console' => 
    array (
      'replaced' => 
      array (
        0 => 'v8.83.27',
      ),
    ),
    'illuminate/container' => 
    array (
      'replaced' => 
      array (
        0 => 'v8.83.27',
      ),
    ),
    'illuminate/contracts' => 
    array (
      'replaced' => 
      array (
        0 => 'v8.83.27',
      ),
    ),
    'illuminate/cookie' => 
    array (
      'replaced' => 
      array (
        0 => 'v8.83.27',
      ),
    ),
    'illuminate/database' => 
    array (
      'replaced' => 
      array (
        0 => 'v8.83.27',
      ),
    ),
    'illuminate/encryption' => 
    array (
      'replaced' => 
      array (
        0 => 'v8.83.27',
      ),
    ),
    'illuminate/events' => 
    array (
      'replaced' => 
      array (
        0 => 'v8.83.27',
      ),
    ),
    'illuminate/filesystem' => 
    array (
      'replaced' => 
      array (
        0 => 'v8.83.27',
      ),
    ),
    'illuminate/hashing' => 
    array (
      'replaced' => 
      array (
        0 => 'v8.83.27',
      ),
    ),
    'illuminate/http' => 
    array (
      'replaced' => 
      array (
        0 => 'v8.83.27',
      ),
    ),
    'illuminate/log' => 
    array (
      'replaced' => 
      array (
        0 => 'v8.83.27',
      ),
    ),
    'illuminate/macroable' => 
    array (
      'replaced' => 
      array (
        0 => 'v8.83.27',
      ),
    ),
    'illuminate/mail' => 
    array (
      'replaced' => 
      array (
        0 => 'v8.83.27',
      ),
    ),
    'illuminate/notifications' => 
    array (
      'replaced' => 
      array (
        0 => 'v8.83.27',
      ),
    ),
    'illuminate/pagination' => 
    array (
      'replaced' => 
      array (
        0 => 'v8.83.27',
      ),
    ),
    'illuminate/pipeline' => 
    array (
      'replaced' => 
      array (
        0 => 'v8.83.27',
      ),
    ),
    'illuminate/queue' => 
    array (
      'replaced' => 
      array (
        0 => 'v8.83.27',
      ),
    ),
    'illuminate/redis' => 
    array (
      'replaced' => 
      array (
        0 => 'v8.83.27',
      ),
    ),
    'illuminate/routing' => 
    array (
      'replaced' => 
      array (
        0 => 'v8.83.27',
      ),
    ),
    'illuminate/session' => 
    array (
      'replaced' => 
      array (
        0 => 'v8.83.27',
      ),
    ),
    'illuminate/support' => 
    array (
      'replaced' => 
      array (
        0 => 'v8.83.27',
      ),
    ),
    'illuminate/testing' => 
    array (
      'replaced' => 
      array (
        0 => 'v8.83.27',
      ),
    ),
    'illuminate/translation' => 
    array (
      'replaced' => 
      array (
        0 => 'v8.83.27',
      ),
    ),
    'illuminate/validation' => 
    array (
      'replaced' => 
      array (
        0 => 'v8.83.27',
      ),
    ),
    'illuminate/view' => 
    array (
      'replaced' => 
      array (
        0 => 'v8.83.27',
      ),
    ),
    'kodova/hamcrest-php' => 
    array (
      'replaced' => 
      array (
        0 => '*',
      ),
    ),
    'laravel/framework' => 
    array (
      'pretty_version' => 'v8.83.27',
      'version' => '8.83.27.0',
      'aliases' => 
      array (
      ),
      'reference' => 'e1afe088b4ca613fb96dc57e6d8dbcb8cc2c6b49',
    ),
    'laravel/laravel' => 
    array (
      'pretty_version' => 'dev-master',
      'version' => 'dev-master',
      'aliases' => 
      array (
      ),
      'reference' => '17e753c7178e4beaf5f18a8a4eb12f7a787e94bf',
    ),
    'laravel/sail' => 
    array (
      'pretty_version' => 'v1.25.0',
      'version' => '1.25.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'e81a7bd7ac1a745ccb25572830fecf74a89bb48a',
    ),
    'laravel/serializable-closure' => 
    array (
      'pretty_version' => 'v1.3.1',
      'version' => '1.3.1.0',
      'aliases' => 
      array (
      ),
      'reference' => 'e5a3057a5591e1cfe8183034b0203921abe2c902',
    ),
    'laravel/tinker' => 
    array (
      'pretty_version' => 'v2.8.2',
      'version' => '2.8.2.0',
      'aliases' => 
      array (
      ),
      'reference' => 'b936d415b252b499e8c3b1f795cd4fc20f57e1f3',
    ),
    'laravel/ui' => 
    array (
      'pretty_version' => 'v3.4.6',
      'version' => '3.4.6.0',
      'aliases' => 
      array (
      ),
      'reference' => '65ec5c03f7fee2c8ecae785795b829a15be48c2c',
    ),
    'league/commonmark' => 
    array (
      'pretty_version' => '2.4.1',
      'version' => '2.4.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '3669d6d5f7a47a93c08ddff335e6d945481a1dd5',
    ),
    'league/config' => 
    array (
      'pretty_version' => 'v1.2.0',
      'version' => '1.2.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '754b3604fb2984c71f4af4a9cbe7b57f346ec1f3',
    ),
    'league/flysystem' => 
    array (
      'pretty_version' => '1.1.10',
      'version' => '1.1.10.0',
      'aliases' => 
      array (
      ),
      'reference' => '3239285c825c152bcc315fe0e87d6b55f5972ed1',
    ),
    'league/mime-type-detection' => 
    array (
      'pretty_version' => '1.13.0',
      'version' => '1.13.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'a6dfb1194a2946fcdc1f38219445234f65b35c96',
    ),
    'livewire/livewire' => 
    array (
      'pretty_version' => 'v2.12.6',
      'version' => '2.12.6.0',
      'aliases' => 
      array (
      ),
      'reference' => '7d3a57b3193299cf1a0639a3935c696f4da2cf92',
    ),
    'maatwebsite/excel' => 
    array (
      'pretty_version' => '3.1.48',
      'version' => '3.1.48.0',
      'aliases' => 
      array (
      ),
      'reference' => '6d0fe2a1d195960c7af7bf0de760582da02a34b9',
    ),
    'maennchen/zipstream-php' => 
    array (
      'pretty_version' => '3.1.0',
      'version' => '3.1.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'b8174494eda667f7d13876b4a7bfef0f62a7c0d1',
    ),
    'markbaker/complex' => 
    array (
      'pretty_version' => '3.0.2',
      'version' => '3.0.2.0',
      'aliases' => 
      array (
      ),
      'reference' => '95c56caa1cf5c766ad6d65b6344b807c1e8405b9',
    ),
    'markbaker/matrix' => 
    array (
      'pretty_version' => '3.0.1',
      'version' => '3.0.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '728434227fe21be27ff6d86621a1b13107a2562c',
    ),
    'masterminds/html5' => 
    array (
      'pretty_version' => '2.8.1',
      'version' => '2.8.1.0',
      'aliases' => 
      array (
      ),
      'reference' => 'f47dcf3c70c584de14f21143c55d9939631bc6cf',
    ),
    'mockery/mockery' => 
    array (
      'pretty_version' => '1.6.6',
      'version' => '1.6.6.0',
      'aliases' => 
      array (
      ),
      'reference' => 'b8e0bb7d8c604046539c1115994632c74dcb361e',
    ),
    'monolog/monolog' => 
    array (
      'pretty_version' => '2.9.1',
      'version' => '2.9.1.0',
      'aliases' => 
      array (
      ),
      'reference' => 'f259e2b15fb95494c83f52d3caad003bbf5ffaa1',
    ),
    'mtdowling/cron-expression' => 
    array (
      'replaced' => 
      array (
        0 => '^1.0',
      ),
    ),
    'myclabs/deep-copy' => 
    array (
      'pretty_version' => '1.11.1',
      'version' => '1.11.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '7284c22080590fb39f2ffa3e9057f10a4ddd0e0c',
    ),
    'nesbot/carbon' => 
    array (
      'pretty_version' => '2.70.0',
      'version' => '2.70.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'd3298b38ea8612e5f77d38d1a99438e42f70341d',
    ),
    'nette/schema' => 
    array (
      'pretty_version' => 'v1.2.4',
      'version' => '1.2.4.0',
      'aliases' => 
      array (
      ),
      'reference' => 'c9ff517a53903b3d4e29ec547fb20feecb05b8ab',
    ),
    'nette/utils' => 
    array (
      'pretty_version' => 'v4.0.1',
      'version' => '4.0.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '9124157137da01b1f5a5a22d6486cb975f26db7e',
    ),
    'nikic/php-parser' => 
    array (
      'pretty_version' => 'v4.17.1',
      'version' => '4.17.1.0',
      'aliases' => 
      array (
      ),
      'reference' => 'a6303e50c90c355c7eeee2c4a8b27fe8dc8fef1d',
    ),
    'nunomaduro/collision' => 
    array (
      'pretty_version' => 'v5.11.0',
      'version' => '5.11.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '8b610eef8582ccdc05d8f2ab23305e2d37049461',
    ),
    'opis/closure' => 
    array (
      'pretty_version' => '3.6.3',
      'version' => '3.6.3.0',
      'aliases' => 
      array (
      ),
      'reference' => '3d81e4309d2a927abbe66df935f4bb60082805ad',
    ),
    'phar-io/manifest' => 
    array (
      'pretty_version' => '2.0.3',
      'version' => '2.0.3.0',
      'aliases' => 
      array (
      ),
      'reference' => '97803eca37d319dfa7826cc2437fc020857acb53',
    ),
    'phar-io/version' => 
    array (
      'pretty_version' => '3.2.1',
      'version' => '3.2.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '4f7fd7836c6f332bb2933569e566a0d6c4cbed74',
    ),
    'phenx/php-font-lib' => 
    array (
      'pretty_version' => '0.5.4',
      'version' => '0.5.4.0',
      'aliases' => 
      array (
      ),
      'reference' => 'dd448ad1ce34c63d09baccd05415e361300c35b4',
    ),
    'phenx/php-svg-lib' => 
    array (
      'pretty_version' => '0.5.0',
      'version' => '0.5.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '76876c6cf3080bcb6f249d7d59705108166a6685',
    ),
    'phpoffice/phpspreadsheet' => 
    array (
      'pretty_version' => '1.29.0',
      'version' => '1.29.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'fde2ccf55eaef7e86021ff1acce26479160a0fa0',
    ),
    'phpoption/phpoption' => 
    array (
      'pretty_version' => '1.9.1',
      'version' => '1.9.1.0',
      'aliases' => 
      array (
      ),
      'reference' => 'dd3a383e599f49777d8b628dadbb90cae435b87e',
    ),
    'phpunit/php-code-coverage' => 
    array (
      'pretty_version' => '9.2.28',
      'version' => '9.2.28.0',
      'aliases' => 
      array (
      ),
      'reference' => '7134a5ccaaf0f1c92a4f5501a6c9f98ac4dcc0ef',
    ),
    'phpunit/php-file-iterator' => 
    array (
      'pretty_version' => '3.0.6',
      'version' => '3.0.6.0',
      'aliases' => 
      array (
      ),
      'reference' => 'cf1c2e7c203ac650e352f4cc675a7021e7d1b3cf',
    ),
    'phpunit/php-invoker' => 
    array (
      'pretty_version' => '3.1.1',
      'version' => '3.1.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '5a10147d0aaf65b58940a0b72f71c9ac0423cc67',
    ),
    'phpunit/php-text-template' => 
    array (
      'pretty_version' => '2.0.4',
      'version' => '2.0.4.0',
      'aliases' => 
      array (
      ),
      'reference' => '5da5f67fc95621df9ff4c4e5a84d6a8a2acf7c28',
    ),
    'phpunit/php-timer' => 
    array (
      'pretty_version' => '5.0.3',
      'version' => '5.0.3.0',
      'aliases' => 
      array (
      ),
      'reference' => '5a63ce20ed1b5bf577850e2c4e87f4aa902afbd2',
    ),
    'phpunit/phpunit' => 
    array (
      'pretty_version' => '9.6.12',
      'version' => '9.6.12.0',
      'aliases' => 
      array (
      ),
      'reference' => 'a122c2ebd469b751d774aa0f613dc0d67697653f',
    ),
    'psr/clock' => 
    array (
      'pretty_version' => '1.0.0',
      'version' => '1.0.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'e41a24703d4560fd0acb709162f73b8adfc3aa0d',
    ),
    'psr/clock-implementation' => 
    array (
      'provided' => 
      array (
        0 => '1.0',
      ),
    ),
    'psr/container' => 
    array (
      'pretty_version' => '1.1.2',
      'version' => '1.1.2.0',
      'aliases' => 
      array (
      ),
      'reference' => '513e0666f7216c7459170d56df27dfcefe1689ea',
    ),
    'psr/container-implementation' => 
    array (
      'provided' => 
      array (
        0 => '1.0',
      ),
    ),
    'psr/event-dispatcher' => 
    array (
      'pretty_version' => '1.0.0',
      'version' => '1.0.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'dbefd12671e8a14ec7f180cab83036ed26714bb0',
    ),
    'psr/event-dispatcher-implementation' => 
    array (
      'provided' => 
      array (
        0 => '1.0',
      ),
    ),
    'psr/http-client' => 
    array (
      'pretty_version' => '1.0.2',
      'version' => '1.0.2.0',
      'aliases' => 
      array (
      ),
      'reference' => '0955afe48220520692d2d09f7ab7e0f93ffd6a31',
    ),
    'psr/http-client-implementation' => 
    array (
      'provided' => 
      array (
        0 => '1.0',
      ),
    ),
    'psr/http-factory' => 
    array (
      'pretty_version' => '1.0.2',
      'version' => '1.0.2.0',
      'aliases' => 
      array (
      ),
      'reference' => 'e616d01114759c4c489f93b099585439f795fe35',
    ),
    'psr/http-factory-implementation' => 
    array (
      'provided' => 
      array (
        0 => '1.0',
      ),
    ),
    'psr/http-message' => 
    array (
      'pretty_version' => '2.0',
      'version' => '2.0.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '402d35bcb92c70c026d1a6a9883f06b2ead23d71',
    ),
    'psr/http-message-implementation' => 
    array (
      'provided' => 
      array (
        0 => '1.0',
      ),
    ),
    'psr/log' => 
    array (
      'pretty_version' => '2.0.0',
      'version' => '2.0.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'ef29f6d262798707a9edd554e2b82517ef3a9376',
    ),
    'psr/log-implementation' => 
    array (
      'provided' => 
      array (
        0 => '1.0|2.0',
        1 => '1.0.0 || 2.0.0 || 3.0.0',
      ),
    ),
    'psr/simple-cache' => 
    array (
      'pretty_version' => '1.0.1',
      'version' => '1.0.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '408d5eafb83c57f6365a3ca330ff23aa4a5fa39b',
    ),
    'psr/simple-cache-implementation' => 
    array (
      'provided' => 
      array (
        0 => '1.0',
      ),
    ),
    'psy/psysh' => 
    array (
      'pretty_version' => 'v0.11.20',
      'version' => '0.11.20.0',
      'aliases' => 
      array (
      ),
      'reference' => '0fa27040553d1d280a67a4393194df5228afea5b',
    ),
    'ralouphie/getallheaders' => 
    array (
      'pretty_version' => '3.0.3',
      'version' => '3.0.3.0',
      'aliases' => 
      array (
      ),
      'reference' => '120b605dfeb996808c31b6477290a714d356e822',
    ),
    'ramsey/collection' => 
    array (
      'pretty_version' => '2.0.0',
      'version' => '2.0.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'a4b48764bfbb8f3a6a4d1aeb1a35bb5e9ecac4a5',
    ),
    'ramsey/uuid' => 
    array (
      'pretty_version' => '4.7.4',
      'version' => '4.7.4.0',
      'aliases' => 
      array (
      ),
      'reference' => '60a4c63ab724854332900504274f6150ff26d286',
    ),
    'rhumsaa/uuid' => 
    array (
      'replaced' => 
      array (
        0 => '4.7.4',
      ),
    ),
    'sabberworm/php-css-parser' => 
    array (
      'pretty_version' => '8.4.0',
      'version' => '8.4.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'e41d2140031d533348b2192a83f02d8dd8a71d30',
    ),
    'sebastian/cli-parser' => 
    array (
      'pretty_version' => '1.0.1',
      'version' => '1.0.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '442e7c7e687e42adc03470c7b668bc4b2402c0b2',
    ),
    'sebastian/code-unit' => 
    array (
      'pretty_version' => '1.0.8',
      'version' => '1.0.8.0',
      'aliases' => 
      array (
      ),
      'reference' => '1fc9f64c0927627ef78ba436c9b17d967e68e120',
    ),
    'sebastian/code-unit-reverse-lookup' => 
    array (
      'pretty_version' => '2.0.3',
      'version' => '2.0.3.0',
      'aliases' => 
      array (
      ),
      'reference' => 'ac91f01ccec49fb77bdc6fd1e548bc70f7faa3e5',
    ),
    'sebastian/comparator' => 
    array (
      'pretty_version' => '4.0.8',
      'version' => '4.0.8.0',
      'aliases' => 
      array (
      ),
      'reference' => 'fa0f136dd2334583309d32b62544682ee972b51a',
    ),
    'sebastian/complexity' => 
    array (
      'pretty_version' => '2.0.2',
      'version' => '2.0.2.0',
      'aliases' => 
      array (
      ),
      'reference' => '739b35e53379900cc9ac327b2147867b8b6efd88',
    ),
    'sebastian/diff' => 
    array (
      'pretty_version' => '4.0.5',
      'version' => '4.0.5.0',
      'aliases' => 
      array (
      ),
      'reference' => '74be17022044ebaaecfdf0c5cd504fc9cd5a7131',
    ),
    'sebastian/environment' => 
    array (
      'pretty_version' => '5.1.5',
      'version' => '5.1.5.0',
      'aliases' => 
      array (
      ),
      'reference' => '830c43a844f1f8d5b7a1f6d6076b784454d8b7ed',
    ),
    'sebastian/exporter' => 
    array (
      'pretty_version' => '4.0.5',
      'version' => '4.0.5.0',
      'aliases' => 
      array (
      ),
      'reference' => 'ac230ed27f0f98f597c8a2b6eb7ac563af5e5b9d',
    ),
    'sebastian/global-state' => 
    array (
      'pretty_version' => '5.0.6',
      'version' => '5.0.6.0',
      'aliases' => 
      array (
      ),
      'reference' => 'bde739e7565280bda77be70044ac1047bc007e34',
    ),
    'sebastian/lines-of-code' => 
    array (
      'pretty_version' => '1.0.3',
      'version' => '1.0.3.0',
      'aliases' => 
      array (
      ),
      'reference' => 'c1c2e997aa3146983ed888ad08b15470a2e22ecc',
    ),
    'sebastian/object-enumerator' => 
    array (
      'pretty_version' => '4.0.4',
      'version' => '4.0.4.0',
      'aliases' => 
      array (
      ),
      'reference' => '5c9eeac41b290a3712d88851518825ad78f45c71',
    ),
    'sebastian/object-reflector' => 
    array (
      'pretty_version' => '2.0.4',
      'version' => '2.0.4.0',
      'aliases' => 
      array (
      ),
      'reference' => 'b4f479ebdbf63ac605d183ece17d8d7fe49c15c7',
    ),
    'sebastian/recursion-context' => 
    array (
      'pretty_version' => '4.0.5',
      'version' => '4.0.5.0',
      'aliases' => 
      array (
      ),
      'reference' => 'e75bd0f07204fec2a0af9b0f3cfe97d05f92efc1',
    ),
    'sebastian/resource-operations' => 
    array (
      'pretty_version' => '3.0.3',
      'version' => '3.0.3.0',
      'aliases' => 
      array (
      ),
      'reference' => '0f4443cb3a1d92ce809899753bc0d5d5a8dd19a8',
    ),
    'sebastian/type' => 
    array (
      'pretty_version' => '3.2.1',
      'version' => '3.2.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '75e2c2a32f5e0b3aef905b9ed0b179b953b3d7c7',
    ),
    'sebastian/version' => 
    array (
      'pretty_version' => '3.0.2',
      'version' => '3.0.2.0',
      'aliases' => 
      array (
      ),
      'reference' => 'c6c1022351a901512170118436c764e473f6de8c',
    ),
    'spatie/laravel-permission' => 
    array (
      'pretty_version' => '4.4.3',
      'version' => '4.4.3.0',
      'aliases' => 
      array (
      ),
      'reference' => '779797a47689d0bc1666e26f566cca44603e56fa',
    ),
    'swiftmailer/swiftmailer' => 
    array (
      'pretty_version' => 'v6.3.0',
      'version' => '6.3.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '8a5d5072dca8f48460fce2f4131fcc495eec654c',
    ),
    'symfony/console' => 
    array (
      'pretty_version' => 'v5.4.28',
      'version' => '5.4.28.0',
      'aliases' => 
      array (
      ),
      'reference' => 'f4f71842f24c2023b91237c72a365306f3c58827',
    ),
    'symfony/css-selector' => 
    array (
      'pretty_version' => 'v6.3.2',
      'version' => '6.3.2.0',
      'aliases' => 
      array (
      ),
      'reference' => '883d961421ab1709877c10ac99451632a3d6fa57',
    ),
    'symfony/deprecation-contracts' => 
    array (
      'pretty_version' => 'v3.3.0',
      'version' => '3.3.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '7c3aff79d10325257a001fcf92d991f24fc967cf',
    ),
    'symfony/error-handler' => 
    array (
      'pretty_version' => 'v5.4.26',
      'version' => '5.4.26.0',
      'aliases' => 
      array (
      ),
      'reference' => 'b26719213a39c9ba57520cbc5e52bfcc5e8d92f9',
    ),
    'symfony/event-dispatcher' => 
    array (
      'pretty_version' => 'v6.3.2',
      'version' => '6.3.2.0',
      'aliases' => 
      array (
      ),
      'reference' => 'adb01fe097a4ee930db9258a3cc906b5beb5cf2e',
    ),
    'symfony/event-dispatcher-contracts' => 
    array (
      'pretty_version' => 'v3.3.0',
      'version' => '3.3.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'a76aed96a42d2b521153fb382d418e30d18b59df',
    ),
    'symfony/event-dispatcher-implementation' => 
    array (
      'provided' => 
      array (
        0 => '2.0|3.0',
      ),
    ),
    'symfony/finder' => 
    array (
      'pretty_version' => 'v5.4.27',
      'version' => '5.4.27.0',
      'aliases' => 
      array (
      ),
      'reference' => 'ff4bce3c33451e7ec778070e45bd23f74214cd5d',
    ),
    'symfony/http-foundation' => 
    array (
      'pretty_version' => 'v5.4.28',
      'version' => '5.4.28.0',
      'aliases' => 
      array (
      ),
      'reference' => '365992c83a836dfe635f1e903ccca43ee03d3dd2',
    ),
    'symfony/http-kernel' => 
    array (
      'pretty_version' => 'v5.4.28',
      'version' => '5.4.28.0',
      'aliases' => 
      array (
      ),
      'reference' => '127a2322ca1828157901092518b8ea8e4e1109d4',
    ),
    'symfony/mime' => 
    array (
      'pretty_version' => 'v5.4.26',
      'version' => '5.4.26.0',
      'aliases' => 
      array (
      ),
      'reference' => '2ea06dfeee20000a319d8407cea1d47533d5a9d2',
    ),
    'symfony/polyfill-ctype' => 
    array (
      'pretty_version' => 'v1.28.0',
      'version' => '1.28.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'ea208ce43cbb04af6867b4fdddb1bdbf84cc28cb',
    ),
    'symfony/polyfill-iconv' => 
    array (
      'pretty_version' => 'v1.28.0',
      'version' => '1.28.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '6de50471469b8c9afc38164452ab2b6170ee71c1',
    ),
    'symfony/polyfill-intl-grapheme' => 
    array (
      'pretty_version' => 'v1.28.0',
      'version' => '1.28.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '875e90aeea2777b6f135677f618529449334a612',
    ),
    'symfony/polyfill-intl-idn' => 
    array (
      'pretty_version' => 'v1.28.0',
      'version' => '1.28.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'ecaafce9f77234a6a449d29e49267ba10499116d',
    ),
    'symfony/polyfill-intl-normalizer' => 
    array (
      'pretty_version' => 'v1.28.0',
      'version' => '1.28.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '8c4ad05dd0120b6a53c1ca374dca2ad0a1c4ed92',
    ),
    'symfony/polyfill-mbstring' => 
    array (
      'pretty_version' => 'v1.28.0',
      'version' => '1.28.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '42292d99c55abe617799667f454222c54c60e229',
    ),
    'symfony/polyfill-php72' => 
    array (
      'pretty_version' => 'v1.28.0',
      'version' => '1.28.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '70f4aebd92afca2f865444d30a4d2151c13c3179',
    ),
    'symfony/polyfill-php73' => 
    array (
      'pretty_version' => 'v1.28.0',
      'version' => '1.28.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'fe2f306d1d9d346a7fee353d0d5012e401e984b5',
    ),
    'symfony/polyfill-php80' => 
    array (
      'pretty_version' => 'v1.28.0',
      'version' => '1.28.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '6caa57379c4aec19c0a12a38b59b26487dcfe4b5',
    ),
    'symfony/process' => 
    array (
      'pretty_version' => 'v5.4.28',
      'version' => '5.4.28.0',
      'aliases' => 
      array (
      ),
      'reference' => '45261e1fccad1b5447a8d7a8e67aa7b4a9798b7b',
    ),
    'symfony/routing' => 
    array (
      'pretty_version' => 'v5.4.26',
      'version' => '5.4.26.0',
      'aliases' => 
      array (
      ),
      'reference' => '853fc7df96befc468692de0a48831b38f04d2cb2',
    ),
    'symfony/service-contracts' => 
    array (
      'pretty_version' => 'v2.5.2',
      'version' => '2.5.2.0',
      'aliases' => 
      array (
      ),
      'reference' => '4b426aac47d6427cc1a1d0f7e2ac724627f5966c',
    ),
    'symfony/string' => 
    array (
      'pretty_version' => 'v6.3.2',
      'version' => '6.3.2.0',
      'aliases' => 
      array (
      ),
      'reference' => '53d1a83225002635bca3482fcbf963001313fb68',
    ),
    'symfony/translation' => 
    array (
      'pretty_version' => 'v6.3.3',
      'version' => '6.3.3.0',
      'aliases' => 
      array (
      ),
      'reference' => '3ed078c54bc98bbe4414e1e9b2d5e85ed5a5c8bd',
    ),
    'symfony/translation-contracts' => 
    array (
      'pretty_version' => 'v3.3.0',
      'version' => '3.3.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '02c24deb352fb0d79db5486c0c79905a85e37e86',
    ),
    'symfony/translation-implementation' => 
    array (
      'provided' => 
      array (
        0 => '2.3|3.0',
      ),
    ),
    'symfony/var-dumper' => 
    array (
      'pretty_version' => 'v5.4.28',
      'version' => '5.4.28.0',
      'aliases' => 
      array (
      ),
      'reference' => '684b36ff415e1381d4a943c3ca2502cd2debad73',
    ),
    'symfony/yaml' => 
    array (
      'pretty_version' => 'v6.3.3',
      'version' => '6.3.3.0',
      'aliases' => 
      array (
      ),
      'reference' => 'e23292e8c07c85b971b44c1c4b87af52133e2add',
    ),
    'theseer/tokenizer' => 
    array (
      'pretty_version' => '1.2.1',
      'version' => '1.2.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '34a41e998c2183e22995f158c581e7b5e755ab9e',
    ),
    'tijsverkoyen/css-to-inline-styles' => 
    array (
      'pretty_version' => '2.2.6',
      'version' => '2.2.6.0',
      'aliases' => 
      array (
      ),
      'reference' => 'c42125b83a4fa63b187fdf29f9c93cb7733da30c',
    ),
    'vlucas/phpdotenv' => 
    array (
      'pretty_version' => 'v5.5.0',
      'version' => '5.5.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '1a7ea2afc49c3ee6d87061f5a233e3a035d0eae7',
    ),
    'voku/portable-ascii' => 
    array (
      'pretty_version' => '1.6.1',
      'version' => '1.6.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '87337c91b9dfacee02452244ee14ab3c43bc485a',
    ),
    'webmozart/assert' => 
    array (
      'pretty_version' => '1.11.0',
      'version' => '1.11.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '11cb2199493b2f8a3b53e7f19068fc6aac760991',
    ),
    'yajra/laravel-datatables-oracle' => 
    array (
      'pretty_version' => 'v9.21.2',
      'version' => '9.21.2.0',
      'aliases' => 
      array (
      ),
      'reference' => 'a7fd01f06282923e9c63fa27fe6b391e21dc321a',
    ),
  ),
);
private static $canGetVendors;
private static $installedByVendor = array();







public static function getInstalledPackages()
{
$packages = array();
foreach (self::getInstalled() as $installed) {
$packages[] = array_keys($installed['versions']);
}


if (1 === \count($packages)) {
return $packages[0];
}

return array_keys(array_flip(\call_user_func_array('array_merge', $packages)));
}









public static function isInstalled($packageName)
{
foreach (self::getInstalled() as $installed) {
if (isset($installed['versions'][$packageName])) {
return true;
}
}

return false;
}














public static function satisfies(VersionParser $parser, $packageName, $constraint)
{
$constraint = $parser->parseConstraints($constraint);
$provided = $parser->parseConstraints(self::getVersionRanges($packageName));

return $provided->matches($constraint);
}










public static function getVersionRanges($packageName)
{
foreach (self::getInstalled() as $installed) {
if (!isset($installed['versions'][$packageName])) {
continue;
}

$ranges = array();
if (isset($installed['versions'][$packageName]['pretty_version'])) {
$ranges[] = $installed['versions'][$packageName]['pretty_version'];
}
if (array_key_exists('aliases', $installed['versions'][$packageName])) {
$ranges = array_merge($ranges, $installed['versions'][$packageName]['aliases']);
}
if (array_key_exists('replaced', $installed['versions'][$packageName])) {
$ranges = array_merge($ranges, $installed['versions'][$packageName]['replaced']);
}
if (array_key_exists('provided', $installed['versions'][$packageName])) {
$ranges = array_merge($ranges, $installed['versions'][$packageName]['provided']);
}

return implode(' || ', $ranges);
}

throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
}





public static function getVersion($packageName)
{
foreach (self::getInstalled() as $installed) {
if (!isset($installed['versions'][$packageName])) {
continue;
}

if (!isset($installed['versions'][$packageName]['version'])) {
return null;
}

return $installed['versions'][$packageName]['version'];
}

throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
}





public static function getPrettyVersion($packageName)
{
foreach (self::getInstalled() as $installed) {
if (!isset($installed['versions'][$packageName])) {
continue;
}

if (!isset($installed['versions'][$packageName]['pretty_version'])) {
return null;
}

return $installed['versions'][$packageName]['pretty_version'];
}

throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
}





public static function getReference($packageName)
{
foreach (self::getInstalled() as $installed) {
if (!isset($installed['versions'][$packageName])) {
continue;
}

if (!isset($installed['versions'][$packageName]['reference'])) {
return null;
}

return $installed['versions'][$packageName]['reference'];
}

throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
}





public static function getRootPackage()
{
$installed = self::getInstalled();

return $installed[0]['root'];
}







public static function getRawData()
{
return self::$installed;
}



















public static function reload($data)
{
self::$installed = $data;
self::$installedByVendor = array();
}




private static function getInstalled()
{
if (null === self::$canGetVendors) {
self::$canGetVendors = method_exists('Composer\Autoload\ClassLoader', 'getRegisteredLoaders');
}

$installed = array();

if (self::$canGetVendors) {
foreach (ClassLoader::getRegisteredLoaders() as $vendorDir => $loader) {
if (isset(self::$installedByVendor[$vendorDir])) {
$installed[] = self::$installedByVendor[$vendorDir];
} elseif (is_file($vendorDir.'/composer/installed.php')) {
$installed[] = self::$installedByVendor[$vendorDir] = require $vendorDir.'/composer/installed.php';
}
}
}

$installed[] = self::$installed;

return $installed;
}
}
