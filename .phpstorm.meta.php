<?php

namespace PHPSTORM_META {

    /** @noinspection PhpIllegalArrayKeyTypeInspection */
    /** @noinspection PhpUnusedLocalVariableInspection */
    $STATIC_METHOD_TYPES = [
      \Omnipay\Omnipay::create('') => [
        'Qiwi_P2P' instanceof \Omnipay\Qiwi\P2PGateway,
      ],
      \Omnipay\Common\GatewayFactory::create('') => [
        'Qiwi_P2P' instanceof \Omnipay\Qiwi\P2PGateway,
      ],
    ];
}
