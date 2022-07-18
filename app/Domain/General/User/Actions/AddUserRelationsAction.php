<?php

namespace App\Domain\General\User\Actions;

use App\Domain\General\Coordinate\Actions\GetUserCoordintatesFromIpAction;
use App\Domain\General\Coordinate\Actions\CreateCoordinateAction;
use App\Domain\Notifications\FirebaseDeviceToken\Actions\AddFirebaseDeviceTokenAction;

use App\Domain\General\Coordinate\DTO\CoordinateDTO;
use App\Domain\Notifications\FirebaseDeviceToken\DTO\FirebaseDeviceTokenDTO;

class AddUserRelationsAction
{
	private static $userId;

	public static function execute($request, $userId){
		Self::$userId = $userId;
		// $coordinates = Self::addCoordinates();
		$firebaseToken = Self::addFirebaseToken($request->fcm_token);

		$data = [
			// 'coordinates' => $coordinates,
			'firebaseToken' => $firebaseToken,
		];
		return $data;
	}

	private static function addCoordinates(){
		$coordinates = GetUserCoordintatesFromIpAction::execute(Self::$userId);
		$coordinateDTO = CoordinateDTO::fromRequest($coordinates);
		if($coordinateDTO->longitude != null && $coordinateDTO->latitude != null){
			$coordinates = CreateCoordinateAction::execute($coordinateDTO);
		}
		return $coordinates;
	}

	private static function addFirebaseToken($fcmToken){
		if($fcmToken == null) return;
		$firebaseDeviceTokenDTO = FirebaseDeviceTokenDTO::fromRequest([
			'user_id' => Self::$userId,
			'fcm_token' => $fcmToken,
		]);

		$firebaseToken = AddFirebaseDeviceTokenAction::execute($firebaseDeviceTokenDTO);
		return $firebaseToken;
	}
}