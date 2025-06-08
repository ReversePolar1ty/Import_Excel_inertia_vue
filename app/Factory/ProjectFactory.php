<?php

namespace App\Factory;

use App\Models\Type;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ProjectFactory
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
    private $paymentFirstStep;
    private $paymentSecondStep;
    private $paymentThirdStep;
    private $paymentForthStep;
    private $comment;
    private $effectiveValue;


    public function __construct($typeId, $title, $contractedAt, $createdAtTime, $deadline, $isOnTime, $isChain, $hasOutsource, $hasInvestors, $serviceCount, $workerCount, $paymentFirstStep, $paymentSecondStep, $paymentThirdStep, $paymentForthStep, $comment, $effectiveValue,){
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
        $this->paymentFirstStep = $paymentFirstStep;
        $this->paymentSecondStep = $paymentSecondStep;
        $this->paymentThirdStep = $paymentThirdStep;
        $this->paymentForthStep = $paymentForthStep;
        $this->comment = $comment;
        $this->effectiveValue = $effectiveValue;
    }

    public static function make($map, $row)
    {
        return new self(
            self::getTypesId($map, $row['tip']),
            $row['naimenovanie'],
            Date::excelToDateTimeObject($row['podpisanie_dogovora']),
            Date::excelToDateTimeObject($row['data_sozdaniia']),
            isset($row['dedlain']) ? Date::excelToDateTimeObject($row['dedlain']) : null,
            isset($row['sdaca_v_srok']) ? self::getBool($row['sdaca_v_srok']) : null,
            isset($row['setevik']) ? self::getBool($row['setevik']) : null,
            isset($row['nalicie_autsorsinga']) ? self::getBool($row['nalicie_autsorsinga']) : null,
            isset($row['nalicie_investorov']) ? self::getBool($row['nalicie_investorov']) : null,
            $row['kolicestvo_uslug'] ?? null,
            $row['kolicestvo_ucastnikov'] ?? null,
            $row['vlozenie_v_pervyi_etap'] ?? null,
            $row['vlozenie_vo_vtoroi_etap'] ?? null,
            $row['vlozenie_v_tretii_etap'] ?? null,
            $row['vlozenie_v_cetvertyi_etap'] ?? null,
            $row['kommentarii'] ?? null,
            $row['znacenie_effektivnosti'] ?? null,
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
