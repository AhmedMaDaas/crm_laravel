<?php

namespace  App\Domain\General\Coordinate\Actions;

use  App\Domain\General\Coordinate\DTO\CoordinateDTO;
use  App\Domain\General\Coordinate\Model\Coordinate;

class CreateCoordinateAction
{
	public static function execute(CoordinateDTO $coordinateDTO){
		$coordinate = Coordinate::create($coordinateDTO->toArray());
		return $coordinate;
	}
}