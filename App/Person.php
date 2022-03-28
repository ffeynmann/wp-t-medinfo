<?php

class Person {
    public $ID       = null;
    public $name     = null;
    public $surname  = null;
    public $sex      = null;
    public $birthday = null;

    public function __construct($ID = '', $name = '', $surname = '', $sex = '', $birthday = '')
    {
        $this->ID       = $ID;
        $this->name     = $name;
        $this->surname  = $surname;
        $this->sex      = $sex;
        $this->birthday = str_replace("\n", '', $birthday);
    }

    public function ageInDays()
    {
        if($birthdayObj = DateTime::createFromFormat('d.m.Y', $this->birthday)) {
            return date_diff(new DateTime(), $birthdayObj)->days;
        }

        return false;
    }
}


class Mankind implements IteratorAggregate  {
    private       $fileName = null;
    public static $instance = null;

    private function __construct() {}

    public static function instance($fileName = '')
    {
        !self::$instance && self::$instance = new static();
        self::$instance->fileName = $fileName;
        return self::$instance;
    }

    public function iterator($searchID = null)
    {
        $handle = fopen(__DIR__ . '/' . $this->fileName, "r");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                $params = explode(';', $line);

                if(!$searchID || ($searchID && $searchID == $params[0])) {
                    yield $params[0] => $params;
                }
            }

            fclose($handle);
        }
    }

    public function getIterator()
    {
        return $this->iteratorPeople();
    }

    public function iteratorPeople($searchID = null)
    {
        foreach ($this->iterator($searchID) as $ID => $params)
        {
            yield $ID => new Person(...$params);
        }
    }

    public function getByID($ID = null)
    {
        foreach ($this->iteratorPeople($ID) as $peopleObj) {
            return $peopleObj;
        }

        return false;
    }

    public function malePercent()
    {
        $stat = [
            'M' => 0,
            'F' => 0
        ];

        foreach ($this->iterator() as $peopleParams) {
            $peopleParams[3] === 'M' ? $stat['M']++ : $stat['F']++;
        }

        return round($stat['M'] / array_sum(array_values($stat)) * 100, 1);
    }
}

$mankind = Mankind::instance('peoples.csv');


$peoples = [];
foreach ($mankind as $ID => $people) {
    $peoples[] = $people;
}

foreach ($mankind as $ID => $people) {
    $a = 9;
}


ob_get_clean();
header('Content-Type: application/json');
echo json_encode(
    [
//        'memory'       => round(memory_get_usage() / 1024 / 1024, 2) . ' Mb',
        'male_percent' => sprintf("%.1f%%", $mankind->malePercent()),
        'people_by_id' => $mankind->getByID(200),
        'age_in_days'  => $mankind->getByID(200)->ageInDays(),
        'list'         => $peoples
    ]
    , JSON_PRETTY_PRINT);


/*
General requirements:
- implement the task as good as you can


Implement a Person class.

Person has following attributes:
- unique integer ID
- name
- surname
- sex M/F
- birth date
You can get these information from the instance but you can not change them. (we do not consider ability to change name or sex)

Operations:
- Get person age in days.

*/
/*
Implement Mankind class, which works with Person instances.

General requirements:
- there can only exist a single instance of the class (Martians are not mankind...)
- allow to use the instance as array (use person IDs as array keys) and allow to loop through the instance via foreach

Required operations:
- Load people from the file (see below)
- Get the Person based on ID
- get the percentage of Men in Mankind



Loading people from the file:

Input file is in CSV format. Each person is in separate line.
Each line contains ID of the person, name, surname, sex (M/F) and birth date in format dd.mm.yyyy.
Attributes are separated by semicolon (;) File is using UTF8 encoding.

Example:
123;Michal;Walker;M;01.11.1962
3457;Pavla;Nowak;F;13.04.1887

Expected number of records in the file <= 1000.

Also suggest how to handle the situation when the file is much larger (100 MiB+) - in terms of this method and the Mankind class itself.


*/

