<?php

namespace  App\Domain\General\Coordinate\Actions;

use  App\Domain\General\Coordinate\DTO\CoordinateDTO;
use  App\Domain\General\Coordinate\Model\Coordinate;
use Helper;

class UpdateCoordinateAction
{
	public static function execute(CoordinateDTO $coordinateDTO){
		$coordinate = Coordinate::find($coordinateDTO->id);
		$data = Helper::filterArray($coordinateDTO->toArray());
		$coordinate->update($data);
		return $coordinate;
	}
}