<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => 'local',

    /*
    |--------------------------------------------------------------------------
    | Default Cloud Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Many applications store files both locally and in the cloud. For this
    | reason, you may specify a default "cloud" driver here. This driver
    | will be bound as the Cloud disk implementation in the container.
    |
    */

    'cloud' => 'rackspace',

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "s3", "rackspace"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'database' => [
            'driver' => 'local',
            'root' => database_path(),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'visibility' => 'public',
        ],

        'origin' => [
            'driver' => 'sftp',
            'host' => '128.199.87.45',
            'port' => 22,
            'username' => 'forge',
            'password' => '',
            'privateKey' => '-----BEGIN RSA PRIVATE KEY-----
MIIEpAIBAAKCAQEA3QRaeYAys2k5Bth950VB2DpdfxRZOgiwHk89h5gt3cwOhwO0
4mZ5I58B0OljuOHNofCkppuuoz0XWjDcK7Z+PhwBsiv8CM3Ly1juQdj4GvDAffsj
yN5R/bLK4i5xgGPbDAm/9gr0IBgQZQW3ZcfOd2ckIbVnmkfmMiHhZlhz35WAB6hZ
IZXv4JIntuyiM3xnWOyFC74U3O4r81fhIlGmOip3D7+ksXfC1f1gVsfca2m9TAz4
BiWgQQTGih85PUoBSZHIS3t/Zcl5E0xk5nRvSZztZPQ9/2elUoOsaJJED4mXqAqm
H8+ZpURxvRc5bwrTB5OpdwadV93bQQ8J4Zcd3wIDAQABAoIBAHZwTsutl33tdVHl
0hKNWqu1G0VuciJXZYnYjPCM7IdfQqm3osdwgppEK4T4jSgWWUve2V0vMHbp1gnP
BS2nrh86gu4oA/fz0LI4BfXjf5FwUrcwTgzmlqmNlot+t/RFjqz0zJndZNWOD7sT
RSSV3l6+Nu6Zd9uFjCZxYYim/fFh/OuZqsdbIOikXC2/7iGJExWW9sdrZX2UNeAv
OU9ZjauJbqNxmyHSmUQzYVzGEbcodjp003cBly/XrdpOYRnYjKtGYanOyrRVpPxT
XIH4D1wncid6ylV+rDtXcn4vaPUkUoOze18QanJU1Iy47LL9RMgxEtrthbe47Inm
Iw4R6wECgYEA+cfMzinOti8XRIYftuV16WzeilwxTT0btUhj+CWM8jOgpOhStGYx
cjvy+qjWDCT2QFVyytsEB5xfJ/bL84mew/1b5JtwE6EREH4WdggLxI002LOIhNTo
Hh5itfsIB8Qjh/psTge/rN1E2JRpqtgXiU8RzYH1/jn7jg4Tz1oBMFkCgYEA4oU0
Ilgv5c9MbyEzWWQ/uRAFBnoePQEFDiLtMWyYLDuNepawArJGO+isPL3eWPv3w553
jYi/SpuswCZr6hadx5dp7ZmILkhGZPP4DjP7JJUNltvHfzMQIpjApKFPK1mlr0jO
wHVHfMwzzDsfqvXQPiJ65ciCkCZoZLzRJdsOOPcCgYEAhbz26cP0zBM2sBfoTzNZ
CNyj4w0t0J9RgKT78deZOe1urB1AexrkireSh6dyxBneR9/4kKjn5XNSd8FqvkEH
YwT6+NJJFhl9W4lHWXdBZcH9c7Hc/NJKXiYC0FFSoWXhaGMrLjRz6oim3hfI5BLD
t19AtvpIzhAZopvi+3jDfjECgYAfwdUBS6PLcDijC+CLE8brRxetRMmge9gdlz/x
wevDp8W5/g5HEn9OPtyG14eoqgqeXkUcjqNi7lhVyA0xEGKmbM/pA7FX68ISvTF1
rEv1YQA6ui1J4/rLHudDLWpQBY14+Zgi205ebLKGW3OhID1FuMfKF0ZWt0vDc8VO
rVtdGQKBgQDyO19gLe1YDHGJKyNkLEihv3zrHR/NlXt7PKa3RUSDVjOytg2u3P5w
bOssJj+YrOiPJiqd+0y+Rjz9XZP0PxfzO2ptpLpo8jRkOlixiHoqNjspwEHjJ/DL
SiVIu6jp0zG/uc/Qw3ylhAmLqBfsGNBH7ZobLiAzUJxQNnauoRIPvQ==
-----END RSA PRIVATE KEY-----',
            'root' => '/home/forge/origin.chinghehuang.com/public/store',
            'timeout' => 20,
            //'directoryPerm' => 0755
        ],

//        'rackspace-images' => [
//            'driver'    => 'rackspace',
//            'username'  => env('RACKSPACE_FS_USERNAME', 'craignetsimple'),
//            'key'       => env('RACKSPACE_FS_KEY', 'b41883ba67d9bdb6c2d4497c8c425bfe'),
//            'container' => env('RACKSPACE_IMAGES_CONTAINER', 'ching-images'),
//            'endpoint'  => 'https://identity.api.rackspacecloud.com/v2.0/',
//            'region'    => 'HKG',
//            'url_type'  => 'publicURL',
//            'url'       => env('RACKSPACE_IMAGES_URL', ''),
//            'url_secure'=> env('RACKSPACE_IMAGES_URL_HTTPS', ''),
//        ],
//
//        'rackspace-videos' => [
//            'driver'    => 'rackspace',
//            'username'  => env('RACKSPACE_FS_USERNAME','craignetsimple'),
//            'key'       => env('RACKSPACE_FS_KEY','b41883ba67d9bdb6c2d4497c8c425bfe'),
//            'container' => env('RACKSPACE_VIDEO_CONTAINER','ching-videos'),
//            'endpoint'  => 'https://identity.api.rackspacecloud.com/v2.0/',
//            'region'    => 'HKG',
//            'url_type'  => 'publicURL',
//            'url'              => env('RACKSPACE_VIDEO_URL',''),
//            'url_secure'       => env('RACKSPACE_VIDEO_URL_HTTPS',''),
//            'url_streaming'    => env('RACKSPACE_VIDEO_STREAMING',''),
//            'url_ios'          => env('RACKSPACE_VIDEO_IOS',''),
//        ],

    ],

];
