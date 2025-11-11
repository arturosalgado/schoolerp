<?php

namespace App\Services;

use App\Gender;

class CurpService
{
    private $firstName;
    private $lastName;
    private $secondLastName;
    private $birthDate;
    private Gender $gender;
    private $stateCode;

    private static function getStateCodes(): array
    {
        return MexicanStatesService::getStatesForCurp();
    }

    private static $invalidWords = [
        'BACA', 'BAKA', 'BUEI', 'BUEY', 'CACA', 'CACO', 'CAGA', 'CAGO', 'CAKA', 'CAKO', 'COGE', 'COGI', 'COJA',
        'COJE', 'COJI', 'COJO', 'COLA', 'CULO', 'FALO', 'FETO', 'GETA', 'GUEI', 'GUEY', 'JETA', 'JOTO', 'KACA',
        'KACO', 'KAGA', 'KAGO', 'KAKA', 'KAKO', 'KOGE', 'KOGI', 'KOJA', 'KOJE', 'KOJI', 'KOJO', 'KOLA', 'KULO',
        'LILO', 'LOCA', 'LOCO', 'LOKA', 'LOKO', 'MAME', 'MAMO', 'MEAR', 'MEAS', 'MEON', 'MIAR', 'MION', 'MOCO',
        'MOKO', 'MULA', 'MULO', 'NACA', 'NACO', 'PEDA', 'PEDO', 'PENE', 'PIPI', 'PITO', 'POPO', 'PUTA', 'PUTO',
        'QULO', 'RATA', 'ROBA', 'ROBE', 'ROBO', 'RUIN', 'SENO', 'TETA', 'VACA', 'VAGA', 'VAGO', 'VAKA', 'VUEI',
        'VUEY', 'WUEI', 'WUEY',
    ];

    private static $particles = [
        'DA', 'DAS', 'DE', 'DEL', 'DER', 'DI', 'DIE', 'DD', 'Y', 'EL', 'LA', 'LOS', 'LAS', 'MC', 'MAC', 'VON', 'VAN'
    ];

    private static $compositeNames = ['MARIA', 'MA', 'JOSE', 'J'];

    public function __construct(string $firstName, string $lastName, string $secondLastName, string $birthDate, string $gender, string $stateOfBirth)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->secondLastName = $secondLastName;
        $this->birthDate = $birthDate;
        $this->gender = Gender::fromString($gender); // Validate and convert to enum
        $this->stateCode = $this->getStateCode($stateOfBirth);
    }



    public function generate(): string
    {
        $lastNamePart = $this->getSignificantNamePart($this->lastName);
        $secondLastNamePart = $this->getSignificantNamePart($this->secondLastName);
        $firstNamePart = $this->getSignificantNamePart($this->firstName, true);

        $paternalInitial = substr($lastNamePart, 0, 1);
        $paternalVowel = $this->getFirstInternalVowel($lastNamePart);
        $maternalInitial = empty($secondLastNamePart) ? 'X' : substr($secondLastNamePart, 0, 1);
        $nameInitial = substr($firstNamePart, 0, 1);

        $fourLetters = $this->filterInvalidWords($paternalInitial . $paternalVowel . $maternalInitial . $nameInitial);
        $datePart = date('ymd', strtotime($this->birthDate));
        $genderPart = $this->gender->getCurpCode(); // Use enum method
        $consonantsPart = $this->getInternalConsonants($lastNamePart, $secondLastNamePart, $firstNamePart);
        $homoclave = $this->getHomoclave();

        $baseCurp = $fourLetters . $datePart . $genderPart . $this->stateCode . $consonantsPart . $homoclave;
        $baseCurp = $baseCurp.$this->getVerifierDigit($baseCurp);
        return $baseCurp;
    }

    private function getSignificantNamePart(string $name, bool $isFirstName = false): string
    {
        $name = $this->normalizeString($name);
        // dump($name);
        $parts = explode(' ', $name);

        $significantPart = '';
        foreach ($parts as $part) {
            if (!in_array($part, self::$particles)) {
                $significantPart = $part;
                break;
            }
        }

        if ($isFirstName) {
            $firstPart = $parts[0] ?? '';
            if (in_array($firstPart, self::$compositeNames) && isset($parts[1])) {
                for ($i = 1; $i < count($parts); $i++) {
                    if (!in_array($parts[$i], self::$particles)) {
                        return $parts[$i];
                    }
                }
            }
        }

        return $significantPart;
    }

    private function normalizeString(string $str): string
    {
        // Remove accents BEFORE converting to uppercase
        $str = str_replace(
            ['Á', 'À', 'Ä', 'Â', 'Ã', 'Å', 'Æ', 'É', 'È', 'Ë', 'Ê', 'Í', 'Ì', 'Ï', 'Î',
                'Ó', 'Ò', 'Ö', 'Ô', 'Õ', 'Ø', 'Ú', 'Ù', 'Ü', 'Û', 'Ñ', 'Ç', 'Ý', 'Ÿ',
                'á', 'à', 'ä', 'â', 'ã', 'å', 'æ', 'é', 'è', 'ë', 'ê', 'í', 'ì', 'ï', 'î',
                'ó', 'ò', 'ö', 'ô', 'õ', 'ø', 'ú', 'ù', 'ü', 'û', 'ñ', 'ç', 'ý', 'ÿ'],
            ['A', 'A', 'A', 'A', 'A', 'A', 'A', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I',
                'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'N', 'C', 'Y', 'Y',
                'a', 'a', 'a', 'a', 'a', 'a', 'a', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i',
                'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'n', 'c', 'y', 'y'],
            $str
        );

        // Now convert to uppercase
        $str = strtoupper($str);

        return trim(preg_replace('/\s+/', ' ', $str));
    }


    private function getStateCode(string $stateOfBirth): string
    {
        // $normalizedState = $this->normalizeString($stateOfBirth);
        $stateCodes = self::getStateCodes();
        //     dump($normalizedState);
        //dump($stateCodes,$stateOfBirth);
        return $stateCodes[$stateOfBirth] ?? 'NE';
    }

    private function getFirstInternalVowel(string $str): string
    {
        $vowels = ['A', 'E', 'I', 'O', 'U'];
        for ($i = 1; $i < strlen($str); $i++) {
            if (in_array($str[$i], $vowels)) {
                return $str[$i];
            }
        }
        return 'X';
    }

    private function filterInvalidWords(string $word): string
    {
        if (in_array($word, self::$invalidWords)) {
            return substr_replace($word, 'X', 1, 1);
        }
        return $word;
    }

    private function getInternalConsonants(string $lastName, string $secondLastName, string $firstName): string
    {
        return $this->getFirstInternalConsonant($lastName) .
            $this->getFirstInternalConsonant($secondLastName) .
            $this->getFirstInternalConsonant($firstName);
    }

    private function getFirstInternalConsonant(string $str): string
    {
        $vowels = ['A', 'E', 'I', 'O', 'U'];
        for ($i = 1; $i < strlen($str); $i++) {
            if (!in_array($str[$i], $vowels) && ctype_alpha($str[$i])) {
                return $str[$i];
            }
        }
        return 'X';
    }

    private function getHomoclave(): string
    {
        return ((int)date('Y', strtotime($this->birthDate)) < 2000) ? '0' : 'A';
    }

    private function getVerifierDigit(string $curp17): string
    {
        $sum = 0;
        for ($i = 0; $i < 17; $i++) {
            $charValue = $this->getCharValue($curp17[$i]);
            $sum += $charValue * (18 - $i);
        }

        $remainder = $sum % 10;
        $result = 10 - $remainder;

        // If result is 10, use 0
        if ($result == 10) {
            return '0';
        }

        return (string)$result;
    }

    private function getCharValue(string $char): int
    {
        // Official RENAPO character mapping: 0-9, A-N, Ñ, O-Z
        if ($char >= '0' && $char <= '9') {
            return ord($char) - ord('0');
        }
        if ($char >= 'A' && $char <= 'N') {
            return ord($char) - ord('A') + 10;
        }
        if ($char == 'Ñ') {
            return 24;
        }
        if ($char >= 'O' && $char <= 'Z') {
            return ord($char) - ord('O') + 25;
        }
        return 0; // Default for unknown characters
    }
}
