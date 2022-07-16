<?php

namespace  App\Domain\General\Coordinate\Actions;

use  App\Domain\General\Coordinate\DTO\CoordinateDTO;
use  App\Domain\General\Coordinate\Model\Coordinate;

class DeleteCoordinateAction
{
	public static function execute(CoordinateDTO $coordinateDTO){
		$coordinate = Coordinate::find($coordinateDTO->id);
		$coordinate->delete();
		return "Deleted Successfully!";
	}
}