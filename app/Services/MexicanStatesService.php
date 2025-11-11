<?php

namespace App\Services;

class MexicanStatesService
{
    /**
     * All Mexican states with their CURP codes
     *
     * @return array<string, array{name: string, curp_code: string}>
     */
    public static function getAllStates(): array
    {
        return [
            'AGU' => ['name' => 'Aguascalientes', 'curp_code' => 'AS'],
            'BCN' => ['name' => 'Baja California', 'curp_code' => 'BC'],
            'BCS' => ['name' => 'Baja California Sur', 'curp_code' => 'BS'],
            'CAM' => ['name' => 'Campeche', 'curp_code' => 'CC'],
            'CHP' => ['name' => 'Chiapas', 'curp_code' => 'CS'],
            'CHH' => ['name' => 'Chihuahua', 'curp_code' => 'CH'],
            'COA' => ['name' => 'Coahuila', 'curp_code' => 'CL'],
            'COL' => ['name' => 'Colima', 'curp_code' => 'CM'],
            'DIF' => ['name' => 'Ciudad de Mexico', 'curp_code' => 'DF'],
            'DUR' => ['name' => 'Durango', 'curp_code' => 'DG'],
            'GUA' => ['name' => 'Guanajuato', 'curp_code' => 'GT'],
            'GRO' => ['name' => 'Guerrero', 'curp_code' => 'GR'],
            'HID' => ['name' => 'Hidalgo', 'curp_code' => 'HG'],
            'JAL' => ['name' => 'Jalisco', 'curp_code' => 'JC'],
            'MEX' => ['name' => 'Estado de Mexico', 'curp_code' => 'MC'],
            'MIC' => ['name' => 'Michoacan', 'curp_code' => 'MN'],
            'MOR' => ['name' => 'Morelos', 'curp_code' => 'MS'],
            'NAY' => ['name' => 'Nayarit', 'curp_code' => 'NT'],
            'NLE' => ['name' => 'Nuevo Leon', 'curp_code' => 'NL'],
            'OAX' => ['name' => 'Oaxaca', 'curp_code' => 'OC'],
            'PUE' => ['name' => 'Puebla', 'curp_code' => 'PL'],
            'QUE' => ['name' => 'Queretaro', 'curp_code' => 'QT'],
            'ROO' => ['name' => 'Quintana Roo', 'curp_code' => 'QR'],
            'SLP' => ['name' => 'San Luis Potosi', 'curp_code' => 'SP'],
            'SIN' => ['name' => 'Sinaloa', 'curp_code' => 'SL'],
            'SON' => ['name' => 'Sonora', 'curp_code' => 'SR'],
            'TAB' => ['name' => 'Tabasco', 'curp_code' => 'TC'],
            'TAM' => ['name' => 'Tamaulipas', 'curp_code' => 'TS'],
            'TLA' => ['name' => 'Tlaxcala', 'curp_code' => 'TL'],
            'VER' => ['name' => 'Veracruz', 'curp_code' => 'VZ'],
            'YUC' => ['name' => 'Yucatan', 'curp_code' => 'YN'],
            'ZAC' => ['name' => 'Zacatecas', 'curp_code' => 'ZS'],
            'EXT' => ['name' => 'Extranjero', 'curp_code' => 'NE'], // Born abroad
        ];
    }

    /**
     * Get only the state names
     *
     * @return array<string>
     */
    public static function getStateNames(): array
    {
        return array_column(self::getAllStates(), 'name');
    }

    /**
     * Get states with key as name and value as curp_code
     *
     * @return array<string, string>
     */
    public static function getStatesForCurp(): array
    {
        $states = [];
        foreach (self::getAllStates() as $stateData) {
            $states[$stateData['name']] = $stateData['curp_code'];
        }
        return $states;
    }

    /**
     * Get states formatted for database seeding
     *
     * @return array<array{name: string}>
     */
    public static function getStatesForSeeding(): array
    {
        $states = [];
        foreach (self::getAllStates() as $stateData) {
            $states[] = ['name' => $stateData['name']];
        }
        return $states;
    }

    /**
     * Get CURP code for a specific state name
     *
     * @param string $stateName
     * @return string|null
     */
    public static function getCurpCodeForState(string $stateName): ?string
    {
        foreach (self::getAllStates() as $stateData) {
            if ($stateData['name'] === $stateName) {
                return $stateData['curp_code'];
            }
        }
        return null;
    }

    /**
     * Validate if a state name exists
     *
     * @param string $stateName
     * @return bool
     */
    public static function isValidState(string $stateName): bool
    {
        return in_array($stateName, self::getStateNames());
    }

    /**
     * Get state name by CURP code
     *
     * @param string $curpCode
     * @return string|null
     */
    public static function getStateNameByCurpCode(string $curpCode): ?string
    {
        foreach (self::getAllStates() as $stateData) {
            if ($stateData['curp_code'] === $curpCode) {
                return $stateData['name'];
            }
        }
        return null;
    }
}
