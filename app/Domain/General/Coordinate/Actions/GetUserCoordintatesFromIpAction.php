<?php

namespace App\Domain\General\Coordinate\Actions;

class GetUserCoordintatesFromIpAction
{
	public static function execute($userId){
		$publicIP = Self::getIp();
        $json     = file_get_contents("http://ipinfo.io/$publicIP/geo");
        $json     = json_decode($json, true);
        $coordinates = Self::setCoordinates($json['loc'] ?? null, $userId);
		return $coordinates;
	}

	private static function setCoordinates($location, $userId){
		if($location == null) 
			return ['latitude' => null, 'longitude' => null, 'user_id' => $userId];

		$coordinatesStr = explode(',', $location);
		return [
			'latitude' => $coordinatesStr[0],
			'longitude' => $coordinatesStr[1],
			'user_id' => $userId
		];
	}

	private static function getIp(){
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
            if (array_key_exists($key, $_SERVER) === true){
                foreach (explode(',', $_SERVER[$key]) as $ip){
                    $ip = trim($ip); // just to be safe
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
                        return $ip;
                    }
                }
            }
        }
        return request()->ip(); // it will return server ip when no client ip found
    }
}