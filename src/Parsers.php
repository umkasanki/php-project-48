<?php

/* Определение пространства имен и импортов вверху */
namespace DiffCalc\Parsers;

use Symfony\Component\Yaml\Yaml;

const FIXTURE_DIR = __DIR__ . '/../fixtures/';

/* Пути к файлам автозагрузки */
$autoloadPaths = [
    __DIR__ . '/../../../autoload.php',
    __DIR__ . '/../vendor/autoload.php'
];

/* Требовать файл автозагрузки */
foreach ($autoloadPaths as $path) {
    if (file_exists($path)) {
        require_once $path;
        break;
    }
}

/* Функция для получения полного пути к файлу */
/**
 * @throws \Exception
 */
function getFilePath(string $fileName): string
{
    $path = FIXTURE_DIR . $fileName;
    if (!file_exists($path)) {
        throw new \Exception("File does not exist: $path");
    }
    return FIXTURE_DIR . $fileName;
}

/* Функция для разбора файла */
/**
 * @throws \Exception
 */
function parseFile(string $fileName, callable $parser)
{
    return $parser(file_get_contents(getFilePath($fileName)));
}

/* Функция для разбора JSON файла */
/**
 * @throws \Exception
 */
function parseJsonFile(string $fileName)
{
    return parseFile($fileName, 'json_decode');
}

/* Функция для разбора YAML файла */
/**
 * @throws \Exception
 */
function parseYamlFile(string $fileName)
{
    return parseFile($fileName, fn($content) => Yaml::parse($content, Yaml::PARSE_OBJECT_FOR_MAP));
}

dump(parseJsonFile('file1.json'));
dump(parseYamlFile('file2.yaml'));




