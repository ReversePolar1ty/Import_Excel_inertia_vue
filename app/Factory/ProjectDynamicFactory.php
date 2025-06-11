<?php

namespace App\Factory;

use App\Models\Type;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ProjectDynamicFactory
{
    private $typeId;
    private $title;
    private $contractedAt;
    private $createdAtTime;
    private $deadline;
    private $isOnTime;
    private $isChain;
    private $hasOutsource;
    private $hasInvestors;
    private $serviceCount;
    private $workerCount;
    private $comment;
    private $effectiveValue;


    public function __construct($typeId, $title, $contractedAt, $createdAtTime, $deadline, $isOnTime, $isChain, $hasOutsource, $hasInvestors, $serviceCount, $workerCount, $comment, $effectiveValue,){
        $this->typeId = $typeId;
        $this->title = $title;
        $this->contractedAt = $contractedAt;
        $this->createdAtTime = $createdAtTime;
        $this->deadline = $deadline;
        $this->isOnTime = $isOnTime;
        $this->isChain = $isChain;
        $this->hasOutsource = $hasOutsource;
        $this->hasInvestors = $hasInvestors;
        $this->serviceCount = $serviceCount;
        $this->workerCount = $workerCount;
        $this->comment = $comment;
        $this->effectiveValue = $effectiveValue;
    }

    public static function make($map, $row)
    {
        return new self(
            self::getTypesId($map, $row[0]),
            $row[1],
            Date::excelToDateTimeObject($row[9]),
            Date::excelToDateTimeObject($row[2]),
            isset($row[7]) ? Date::excelToDateTimeObject($row[7]) : null,
            isset($row[8]) ? self::getBool($row[8]) : null,
            isset($row[3]) ? self::getBool($row[3]) : null,
            isset($row[5]) ? self::getBool($row[5]) : null,
            isset($row[6]) ? self::getBool($row[6]) : null,
            $row[10] ?? null,
            $row[4] ?? null,
            $row[11] ?? null,
            $row[12] ?? null,
        );
    }

    private static function getTypesId($map, $title)
    {
        return $map[$title] ?? Type::create(['title' => $title])->id;
    }

    private static function getBool($item): bool
    {
        return $item === 'Да';
    }

    public function getValues(): array
    {
        $props = get_object_vars($this);
        $result = [];
        foreach ($props as $key => $prop) {
            $result[Str::snake($key)] = $prop;
        }
        return $result;
    }
}
