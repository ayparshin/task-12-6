<?php
$example_persons_array = [
    [
        'fullname' => 'Иванов Иван Иванович',
        'job' => 'tester',
    ],
    [
        'fullname' => 'Степанова Наталья Степановна',
        'job' => 'frontend-developer',
    ],
    [
        'fullname' => 'Пащенко Владимир Александрович',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Громов Александр Иванович',
        'job' => 'fullstack-developer',
    ],
    [
        'fullname' => 'Славин Семён Сергеевич',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Цой Владимир Антонович',
        'job' => 'frontend-developer',
    ],
    [
        'fullname' => 'Быстрая Юлия Сергеевна',
        'job' => 'PR-manager',
    ],
    [
        'fullname' => 'Шматко Антонина Сергеевна',
        'job' => 'HR-manager',
    ],
    [
        'fullname' => 'аль-Хорезми Мухаммад ибн-Муса',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Бардо Жаклин Фёдоровна',
        'job' => 'android-developer',
    ],
    [
        'fullname' => 'Шварцнегер Арнольд Густавович',
        'job' => 'babysitter',
    ],
];

function getFullnameFromParts($surname, $name, $patronomyc){
    $fullName = $surname." ".$name." ".$patronomyc;
//    echo $fullName;
    return $fullName;
}

function getPartsFromFullname($fullName){
	$values = explode(" ", $fullName);
	$keys = ['surname', 'name', 'patronomyc'];
	$fullNameMass = array_combine($keys, $values);
//	print_r($fullNameMass);
	return $fullNameMass;
}

function getShortName($fullName){
    $mass = getPartsFromFullname($fullName);
    $name = $mass['name'];
    $surname = $mass['surname'];
    $surnameLetter = mb_substr($surname, 0, 1);
    $shortName = $name." ".$surnameLetter.".";
    return $shortName;
}

function getGenderFromName($fullName){
    $mass = getPartsFromFullname($fullName);
    $sex = 0;
    $sumOfSex = 0;
    $surname = $mass['surname'];
    $name = $mass['name'];
    $patronomyc = $mass['patronomyc'];
    if ((mb_substr($patronomyc, -3)) === "вна"){
    	$sumOfSex--;
    } elseif((mb_substr($patronomyc, -2)) === "ич"){
    	$sumOfSex++;
    }
//    echo ($sumOfSex);
    
    if ((mb_substr($name, -1)) === "а"){
    	$sumOfSex--;
    } elseif(((mb_substr($name, -1)) === "й") || (mb_substr($name, -1)) === "н"){
    	$sumOfSex++;
    }
//    echo ($sumOfSex);
    
    if ((mb_substr($surname, -2)) === "ва"){
    	$sumOfSex--;
    } elseif((mb_substr($surname, -1)) === "в"){
    	$sumOfSex++;
    }
//    echo ($sumOfSex);
    
    if ($sumOfSex > 0){
    	$sex = 1;
    } elseif ($sumOfSex < 0){
    	$sex = -1;
    } else {
    	$sex = 0;
    }
//    echo ($sex);
    return $sex;
}

function getMenMassive($someName){
	$somebody = getGenderFromName($someName);
	if ($somebody === 1){
		$somebody = true;
	} else {
		$somebody = false;
	}
	return $somebody;
}

function getWomanMassive($someName){
	$somebody = getGenderFromName($someName);
	if ($somebody === -1){
		$somebody = true;
	} else {
		$somebody = false;
	}
	return $somebody;
}

function getUndefinedMassive($someName){
	$somebody = getGenderFromName($someName);
	if ($somebody === 0){
		$somebody = true;
	} else {
		$somebody = false;
	}
	return $somebody;
}


function getGenderDescription ($massi){
	$massive = [];
	for ($i = 0; $i <= (count($massi)-1); $i++) {
	$massive[$i] = $massi[$i]['fullname'];
}
	$mensMassive = array_filter($massive, 'getMenMassive');
	$percentOfMan = round((count($mensMassive) / count($massi)*100),1);
	$womanMassive = array_filter($massive, 'getWomanMassive');
	$percentOfWoman = round((count($womanMassive) / count($massi)*100),1);
	$undefinedMassive = array_filter($massive, 'getUndefinedMassive');
	$percentOfUnknow = round((count($undefinedMassive) / count($massi)*100),1);
	
	echo <<<HEREDOCLETTER
Гендерный состав аудитории:
---------------------------
Мужчины - $percentOfMan%
Женщины - $percentOfWoman%
Не удалось определить - $percentOfUnknow%
HEREDOCLETTER;

}
